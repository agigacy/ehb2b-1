<template>
    <div class="row d-flex p-0 legasis-header">
        <div class="col-md-5 col-sm-12 navbar navbar-expand navbar-light bg-blue topbar mb-0 static-top shadow p-0 py-3">
            <a class="sidebar-brand d-flex align-items-left justify-content-left col-md-5 col-sm-5 pr-0" href="/">
                <div class="sidebar-brand-icon pl-2 pr-0 d-flex mt-2 mb-0 mobile-show">
                    <img src="https://legasis.com.my/v3/legasis-logo-only-80px.png" width="38px" height="38px" class="ratio ratio-1x1" />
                    <h4 class="pt-3 pl-2 text-uppercase" style="font-size: 14px !important; font-weight: bold; letter-spacing: 0.05em;">Legasis<sup> V4.0</sup></h4>
                    
                <!-- <div class="sidebar-brand-text mx-1">Legasis<sup> V4.0</sup></div> -->
                </div>
                <div class="sidebar-brand-icon pl-2 pr-2 d-flex my-3 mobile-hidden">
                    <img src="https://legasis.com.my/v3/legasis-logo-only-80px.png" width="48px" />
                    <h4 class="pt-3 pl-2 text-uppercase" style="font-size: 18px !important; font-weight: bold; letter-spacing: 0.05em;">Legasis<sup> V4.0</sup></h4>                    
                <!-- <div class="sidebar-brand-text mx-1">Legasis<sup> V4.0</sup></div> -->
                </div>
            </a>
            <div class="float-right text-right text-light col-md-7 col-sm-7 mobile-show pl-0">
                <div class="row px-1">
                    <div class="col-10 pl-0 pr-1 text-muted">
                        <a id="navbarDropdown" class="dropdown-toggle pb-0 mb-0 text-right" role="button" href="#" data-toggle="dropdown"
                            style="color: #F6f6f6"
                            aria-haspopup="true" aria-expanded="false">
                            {{ this.$userEmail }} 
                        </a>                        
                        <div class="dropdown-menu dropdown-menu-right bg-gray-light pb-2 pt-1 text-center" style="background-color: #f8f8f8; right: -60px" aria-labelledby="navbarDropdown">
                            <div class="row text-center">
                                <center style="margin-left: 20px">
                                    <!-- <img src="storage/uploads/1647586516_A-Logo-Agiga-Logo-Draft-3000px.png" class="text-center rounded-circle p-2" style="max-width: 50px; text-align: center" /> -->
                                    <img src="storage/uploads/1648013161_legasis-logo-price.png" class="text-center rounded-circle p-2" style="max-width: 80px; text-align: center" />
                                    <br />
                                    <a class="font-weight-bold text-center">{{ this.$userName.charAt(0).toUpperCase() + this.$userName.substr(1) }}</a>
                                </center>
                            </div>
                            <hr />
                            <a class="dropdown-item text-left text-dark" href="/user/profile"><i class="fas fa-user mr-2"></i>Update Profile</a>
                            <a class="dropdown-item text-left text-dark" href="/user/profile"><i class="fas fa-gear mr-2"></i>Change Password</a>                            
                        </div>

                        <br />{{ this.$userGroup }} @ <b>{{ this.$companyName }}</b>                    
                    </div>
                    <div class="col-2 pl-2">
                        <a id="navbarDropdown" class="dropdown-toggle nav-link notification text-muted" role="button" href="#" @click="handleLogoutWithTimerOptions"
                            aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-power-off text-muted mt-2" style="font-size: 1.5em;"></i>
                        </a>
                    </div>
                </div>
            </div>


            <div class="float-right justify-content-right text-light col-md-7 mobile-hidden">{{ this.$appName }}<br />
                Email: {{ this.$userEmail }}  &#8226; Team: {{ this.$userGroup }} @ <b>{{ this.$companyName }}</b>
            </div>
        </div>
        <div class="col-md-7 p-0 mt-0 col-sm-12">
            <nav class="navbar navbar-expand navbar-light bg-blue topbar mb-2 static-top shadow  d-flex d-flex justify-content-end">
                <ul class="navbar-nav ml-auto top-notification-menu">
                    
                    <li class="mr-1 mt-3 md-col-6 w-60">
                        <span style="margin-right: 2px; color: #f9f9f9; max-height: 80px; top: 0 !important; padding-top: auto;">
                            <!-- <strong>Running Timesheet</strong> -->
                            <TimerNotification ref="timer" :timer_projects="timer_projects" v-if="!($route.path == '/timer')" />                            
                        </span>
                    </li>
                    
                    
                    <li class="fontsearch mr-2 mt-4">                        
                        <router-link target="_self"
                            :to="{ name: 'reminder' }" v-if="!($route.path == '/reminder')"
                            class="btn btn-md p-3 btn-warning" title="Reminder Page"><a><i class="fa fa-clock fa-lg mt-0 text-dark" style="top: 12px !important"></i></a></router-link>
                    </li>
                    <li class="fontsearch mr-2 mt-4">
                        
                        <button
                            type="button"
                            class="btn btn-info btn-md p-3"
                            @click="showModalTimer"
                            title="Show Fixed Modal"
                            >
                            <center><i class="fa fa-clock fa-lg mt-0" style="top: 12px !important"></i></center>
                        </button>

                        <Modal
                            v-show="isModalTimerVisible"
                            @close="closeModalTimer">

                            <template v-slot:header>
                                Timer Recording For Timehseet
                            </template>

                            <template v-slot:body>
                            </template>

                            <template v-slot:footer>
                                Timer for Timesheet
                            </template>
                            
                        </Modal>
                    </li>
                    
                    <li class="fontsearch mr-3 mt-4 mobile-hidden" v-if="$check_role('Admin', 'super-admin')">

                        <button
                            type="button"
                            class="btn btn-info btn-md p-3"
                            @click="showModal"
                            title="Quick Search"
                            >
                            <center><i class="fa fa-search fa-lg mt-0" style="top: 12px !important"></i></center>
                        </button>

                        <Modal
                            v-show="isModalVisible"
                            @close="closeModal">

                            <template v-slot:header>
                                Quick Search (File, Contact & Client)
                            </template>

                            <template v-slot:body>
                                <ais-instant-search :search-client="searchClient" index-name="file_listing">
                                    <ais-search-box class="mb-2" />
                                    <ais-configure :hits-per-page.camel="12"  :distinct="true" />
                                       
                                    <ais-hits>
                                        <template v-slot:item="{ item }">
                                            <!-- <p v-if="!hits.length">Not found for: <q>{{ item }}</q></p> -->
                                            <div>
                                                <p class="mt-0 mb-0" style="font-size: 12px"><b>{{ item.fileNo }}/ {{ item.fileYear }} </b></p>
                                                <p class="mt-0 mb-0 text-muted" style="font-size: 12px">{{ item.description.substr(0, 90) + '..' }} <br /> <b>Suit:</b> {{ item.suitNo }}</p>
                                                <p class="mt-0 mb-1 text-muted" style="font-size: 12px"><b> {{ item.clientName }} </b> <br /> {{ item.clientEmail }} </p>
                                                <router-link @click.native="closeModal" target="_self"
                                                    :to="{ name: 'filedetails', params: { id: item.id } }" 
                                                    class="btn btn-sm btn-success"><a><i class="fas fa-file mb-1"></i></a> Open File</router-link>
                                                <router-link target="_blank"
                                                    :to="{ name: 'filedetails', params: { id: item.id } }" 
                                                    class="btn btn-sm btn-success"><a><i class="fas fa-file mb-1"></i></a> Open File (New tab)</router-link>
                                                <br />
                                            </div>
                                        </template>
                                    </ais-hits>
                                </ais-instant-search> 
                            </template>

                            <template v-slot:footer>
                                Showing Maximum 12 Result(s) NOW
                            </template>
                            
                        </Modal>
                        
                        
                    </li>

                    <li class="mr-1 mt-4 fixed-width-item mobile-hidden">
                        <span style="color: #CCC; padding-right: 10px; font-size: 15px; letter-spacing: 0.1em; font-family: 'Orbitron', sans-serif; line-height: 14px" class="py-2 w-20">{{ timestampTime }}</span>
                            <br />
                        <span style="color: #FFF; padding-right: 4px; font-size: 10px; letter-spacing: 0.1 em; font-family: 'Orbitron', sans-serif; padding-top: -20px">{{ timestampDate }}</span>
                    </li>

                    <!-- New Todo notification - list each one -->
                    <li class="nav-item dropdown mr-2" >
                        <a id="navbarDropdown" class="dropdown-toggle nav-link notification" role="button" href="#" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-bell" id="notify_icon" style="font-size: 1.5em;" title="Todo/ Next Action Notification"></i>
                            <!-- <span class="badge" id="notify_num">{{ unreadnotifications.toString().length }}</span> -->
                            <span class="badge" id="notify_num" v-show="unreadnotifications.length > 0 && unreadnotifications.length <= 9">{{ unreadnotifications.length }}</span>
                            <span class="badge" id="notify_num" v-show="unreadnotifications.length >= 10 && unreadnotifications.length < 99">{{ unreadnotifications.length }}</span>
                            <span class="badge" id="notify_num" v-show="unreadnotifications.length >= 99">99+</span>
                        </a>

                        <div class="dropdown-menu modal-notification dropdown-menu-right bg-gray-light pb-2 pt-1 mr-2 pr-2 notification-panel" 
                            style="background-color: #f8f8f8; right: 10px; width: 250px;" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item text-center" v-show="unreadnotifications.length > 0" @click.stop="markAsRead" style="cursor: pointer;">Mark All Todo(s) As Read</a>
                            <div class="dropdown-item py-1 px-1" v-for="(unread, index) in unreadnotifications" :key="unread.id" @click.stop="" @mouseover="setHoveredIndex(index)" @mouseleave="setHoveredIndex(null)">
                                <div class="mt-1 py-0 mb-0" @mouseover="hovered = true" @mouseleave="hovered = false" style="font-size: 80%; color: #383838; margin-top: 4px; padding-left: 6px" :style="unread.data.todo.priority == 3 ? 'border-left: 4px solid #d15a5a' :  unread.data.todo.priority == 2 ? ' border-left: 4px solid #465ee8' : ' border-left: 4px solid #67a9e0' ">
                                    <div class="mb-1">
                                        <!-- <b :class="{ 'active-btn': isActiveFile }" class="btn btn-lg my-1 mx-0 py-0 px-1 w-15 font-weight-bold mobile-style">{{unread.data.fileNo}}/ {{unread.data.fileYear}} </b><br /> -->
                                        <router-link class="file-btn btn btn-lg my-1 mx-0 py-0 px-1 w-15 font-weight-bold mobile-style"
                                                    :to="{ name: 'filedetails', params: { id: unread.data.todo.fileId } }"
                                                    ><a>{{unread.data.fileNo}}/ {{unread.data.fileYear}}</a></router-link>
                                                    <br />
                                        <!-- <a class="btn btn-lg my-1 mx-0 py-0 px-1 w-15 font-weight-bold mobile-style">{{unread.data.fileNo}}/ {{unread.data.fileYear}} </a><br /> -->
                                        <b :title="unread.data.todo_id">{{unread.data.todo_status}} {{unread.data.fileStatusDesc}}</b> @ <b>{{unread.data.todo.toDoDate | formatDate}}</b> <!--(ID: {{unread.data.todo_id}} {{unread.data.file_status_id}}) --> <br />
                                        <span class="text-muted font-weight-bold" :title="unread.data.todo.description">{{ unread.data.todo.description.length > 40 ? unread.data.todo.description.substr(0, 40) + '...' : unread.data.todo.description }}</span><br />
                                       
                                        <span class="text-muted text-secondary float-right" v-if="todoIsMoreThanTenDaysAgo(unread.created_at)" :title="moment(unread.created_at).fromNow()">
                                            Created {{ unread.created_at | formatDate }} / By <b :title="'Added by ' + unread.data.user_name.charAt(0).toUpperCase() + unread.data.user_name.substr(1)">{{ unread.data.user_name == $userName ? 'You' : unread.data.user_name.charAt(0).toUpperCase() + unread.data.user_name.substr(1) }}</b>
                                        </span>
                                        <span class="text-muted text-secondary float-right" v-else :title="unread.created_at | formatDate">
                                            Created {{ moment(unread.created_at).fromNow() }} / By <b :title="'Added by ' + unread.data.user_name.charAt(0).toUpperCase() + unread.data.user_name.substr(1)">{{ unread.data.user_name == $userName ? 'You' : unread.data.user_name.charAt(0).toUpperCase() + unread.data.user_name.substr(1) }}</b>
                                        </span>
                                        <br />
                                        <div class="py-1 row d-flex align-items-center">
                                            <router-link 
                                                :to="{ name: 'filedetails', params: { id:  unread.data.todo.fileId }, hash: '#v-pills-todos' }"
                                                v-show="isHovered(index)" class="gotofilepage-btn btn btn-sm btn-warning ml-1 text-dark">
                                                <a target="_blank"><i class="fas fa-file mb-1"></i></a>
                                                File's Todo
                                            </router-link>

                                            <button class="btn btn-sm btn-danger ml-1" @click.stop="markOneAsRead(unread)" data-toggle="tooltip" v-show="isHovered(index)"
                                                data-placement="left" title="Mark this as read">
                                                <!-- <i class="fas fa-trash fa-2"></i> -->
                                                <i class="fas fa-minus fa-2"></i>
                                            </button>
                                        </div>
                                        <hr class="pb-0 mb-1 pt-0 mt-1" />
                                    </div>
                                </div>
                            </div>
                            <a class="dropdown-item" v-show="unreadnotifications.length == 0">No New Notification(s)</a>
                        </div>
                    </li>

                    <!-- new File status notification -->
                    <li class="nav-item dropdown mx-1">
                        <a id="navbarDropdown" class="dropdown-toggle nav-link notification" role="button" href="#" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-comment" id="notify_icon" style="font-size: 1.5em;" title="File Status Notification"></i>
                            <!-- <i class="far fa-comment-alt-exclamation" id="notify_icon"></i> -->
                            <span class="badge" id="notify_num" v-show="unreadnotificationsFileStatus.length > 0 && unreadnotificationsFileStatus.length <= 9">{{ unreadnotificationsFileStatus.length }}</span>
                            <span class="badge" id="notify_num" v-show="unreadnotificationsFileStatus.length >= 10 && unreadnotificationsFileStatus.length < 99">{{ unreadnotificationsFileStatus.length }}</span>
                            <span class="badge" id="notify_num" v-show="unreadnotificationsFileStatus.length >= 99">99+</span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right bg-gray-light pb-2 pt-1 pr-0 notification-panel" 
                            style="background-color: #f8f8f8; right: 10px; width: 250px;" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item text-center" v-show="unreadnotificationsFileStatus.length > 0" @click.stop="markAsReadFileStatus" style="cursor: pointer;">Mark All File Status As Read</a>

                            <div class="dropdown-item pb-0 pt-1 px-1" v-for="(group, index) in groupedNotifications" :key="index" @click.stop="" @mouseover="setHoveredIndex(index)" @mouseleave="setHoveredIndex(null)">
                                <div class="mt-1 py-0 mb-0 pb-1" style="font-size: 80%; color: #383838; margin-top: 4px; padding-left: 10px; border-left: 4px solid #FFF000" 
                                    @mouseover="hovered = true" @mouseleave="hovered = false" >
                                
                                    <div class="mb-1">
                                        <router-link class="file-btn-status btn btn-lg my-1 mx-0 py-0 px-1 w-15 font-weight-bold mobile-style"
                                                    :to="{ name: 'filedetails', params: { id: group[0].data.fileId[0] } }"
                                                    exact-active-class="active"
                                                    ><a>{{group[0].data.fileNo}} / {{group[0].data.fileYear}}</a></router-link> <sup style="font-size: 10px; font-style: italic; color: gray">{{ group.length }} New Notification</sup> <br />                                  
                                        <!-- <b class="file-btn btn btn-lg btn-success m-1 py-0 px-1 w-15 font-weight-bold mobile-style">{{ group[0].data.fileNo }}/ {{ group[0].data.fileYear }}</b><br /> -->

                                        <div v-for="(notification, notificationIndex) in group.slice(0,5)" :key="notificationIndex" class="px-1 mb-1">
                                            <span v-if="notification.data.fileStatusDesc.length >= 40" :title="notification.data.fileStatusDesc">
                                                <b>{{ notification.data.fileStatusDesc.substr(0, 40) + '...'}}</b>
                                                <br />
                                            </span>
                                            <span v-else>
                                                <b>{{ notification.data.fileStatusDesc }}</b>
                                                <br />
                                            </span>

                                            <span class="row pt-0 pb-2">
                                                <!-- <b :title="'Added by ' + notification.data.user_name.charAt(0).toUpperCase() + notification.data.user_name.substr(1)">{{ notification.data.user_name.charAt(0).toUpperCase() + notification.data.user_name.substr(1) }}</b> @ -->
                                                <span class="text-muted float-right" v-if="isMoreThanTenDaysAgo(notification.created_at)" :title="moment(notification.created_at).fromNow()">
                                                   @ {{ notification.created_at | formatDate }} / By <b :title="'Added by ' + notification.data.user_name.charAt(0).toUpperCase() + notification.data.user_name.substr(1)">{{ notification.data.user_name == $userName ? 'You' : notification.data.user_name.charAt(0).toUpperCase() + notification.data.user_name.substr(1) }}</b>
                                                </span>
                                                <span class="text-muted float-right" v-else :title="notification.created_at | formatDate">
                                                   @ {{ moment(notification.created_at).fromNow() }} / By <b :title="'Added by ' + notification.data.user_name.charAt(0).toUpperCase() + notification.data.user_name.substr(1)">{{ notification.data.user_name == $userName ? 'You' : notification.data.user_name.charAt(0).toUpperCase() + notification.data.user_name.substr(1) }}</b>
                                                </span>
                                            </span>
                                        </div>
                                        <div class="row col-md-12 flex-row-reverse">
                                            <span v-if="group.length > 5" class="float-right pr-2">+ {{ group.length - 5 }} More </span>
                                        </div>

                                            
                                        <div class="row m-0 d-flex pt-1">
                                            <router-link  v-show="isHovered(index)"
                                                :to="{ name: 'filedetails', params: { id: group[0].data.fileId[0] }, hash: '#v-pills-status' }"
                                                    class="gotofilepage-btn btn btn-sm btn-warning text-dark"><a target="_blank"><i class="fas fa-file mb-1"></i></a> File's Status</router-link>
                                                    
                                            <button class="btn btn-sm btn-danger ml-1" @click.stop="" data-toggle="tooltip"  v-show="isHovered(index)"
                                                data-placement="left" title="Mark this as read">
                                                <i class="fas fa-minus fa-2"></i>
                                            </button>
                                        </div>
                                        <hr class="pb-0 mb-0 pt-1 mt-1" />        
                                    </div>                            
                                </div>
                            </div>
                            <a class="dropdown-item" v-show="unreadnotificationsFileStatus.length == 0">No New Message(s)</a>
                        </div>
                    </li>

                    <li class="nav-item dropdown ml-2 mobile-hidden">

                        <a id="navbarDropdown" class="dropdown-toggle nav-link notification text-center" role="button" href="#" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-user mr-2 ml-1 pt-2" style="font-size: 1.5em;"><br />
                            <span class="font-weight-normal text-center text-muted small">{{ this.$userName.charAt(0).toUpperCase() + this.$userName.substr(1,3) }}</span></i>

                            <!-- <a class="font-weight-bold text-center">{{ this.$userName.charAt(0).toUpperCase() + this.$userName.substr(1) }}</a> -->

                        </a>
                        <div class="dropdown-menu dropdown-menu-right bg-gray-light pb-2 pt-1 text-center" style="background-color: #f8f8f8; right: -60px" aria-labelledby="navbarDropdown">
                            <!-- <a class="dropdown-item text-left">{{ this.$userName }}</a> -->
                            <div class="row text-center">
                                <center style="margin-left: 20px">
                                    <!-- <img src="storage/uploads/1647586516_A-Logo-Agiga-Logo-Draft-3000px.png" class="text-center rounded-circle p-2" style="max-width: 50px; text-align: center" /> -->
                                    <img src="storage/uploads/1648013161_legasis-logo-price.png" class="text-center rounded-circle p-2" style="max-width: 80px; text-align: center" />
                                    <br />
                                    <a class="font-weight-bold text-center">{{ this.$userName.charAt(0).toUpperCase() + this.$userName.substr(1) }}</a>
                                </center>
                            </div>
                            <hr />
                            <a class="dropdown-item text-left text-dark" href="/user/profile"><i class="fas fa-user mr-2"></i>Update Profile</a>
                            <a class="dropdown-item text-left text-dark" href="/user/profile"><i class="fas fa-gear mr-2"></i>Change Password</a>
                            
                        </div>
                    </li>

                    <li class="nav-item mr-1 mobile-hidden">
                        <!-- <a id="navbarDropdown" class="dropdown-toggle nav-link notification" role="button" href="#" @click="handleLogout" -->
                        <a id="navbarDropdown" class="dropdown-toggle nav-link notification" role="button" href="#" @click="handleLogoutWithTimerOptions"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-power-off" style="font-size: 1.5em;"></i>
                        </a>
                    </li>
                    
                </ul>
            </nav>
        </div>        

        <!-- Modal for Reminder Pop up -->
        
        <div v-if="!($route.path == '/reminder') && !minimized" :class="{ 'modal': !minimized, 'fade': !minimized, 'show': !minimized }"
            id="reminderModal" tabindex="-1" role="dialog" aria-labelledby="reminderModalLabel" aria-hidden="true" 
            style="animation: fadeIn 0.5s ease-in; box-shadow: 5px 10px #383838 ;"
        >
        <!-- data-backdrop="false" -->
            <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                <div class="modal-content h-60">
                    <div class="modal-header bg-warning">
                    <h5 class="modal-title" id="reminderModalLabel"><i class="fa fa-lg fa-clock pr-2"></i>Reminder(s)</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <button class="minimize float-right ml-4 mt-1 btn-outline-info btn btn-sm" @click="toggleMaximize" aria-label="Minimize">
                        <i class="fa fa-window-minimize fa-fw"></i>
                        <!-- <i class="ri-arrow-down-circle-line p-1" style="font-size: 20px"></i> -->
                    </button>
                    </div>
                    <div class="modal-body">
                        <h4 v-if="reminders.length > 1">You have total of <b>{{ reminders.length }}</b> Reminder(s) Today:</h4>
                        <h4 v-if="reminders.length == 1">You have 1 Reminder Today:</h4>
                        <ul style="font-size: 18px" class="pt-2 pl-0 ml-0">
                            <li class="text-info font-weight-bold list-unstyled py-2 bg-light my-2" v-for="(reminder, index) in reminders" :key="index">
                                <div class="row col-md-12 mobile-show">
                                    <div class="col col-md-12 mb-2"> <!-- Adjust column classes -->
                                        <span class="mb-2" v-for="file in files.filter(file => file.id == ((reminderProjects.find(project => project.id === reminder.project_id) || {}).fileId))" :key="file.id">
                                <!-- {{ (this.files.find(file => file.id == fileId) || {}).fileNo || [] }} / {{ (this.files.find(file => file.id == fileId) || {}).fileYear || [] }} -->

                                            <span class="btn btn-sm btn-success py-0 px-1 mr-2 mt-2">{{ file.fileNo }} / {{ file.fileYear }}</span><br />
                                        </span>                                    
                                        <span class="pt-1" v-if="moment(reminder.reminder_date).format('HH:mma DD MMM YYYY').includes('00:00am')">{{ reminder.name }} <small>
                                            <br /> {{ moment(reminder.reminder_date).format('HH:mma DD MMM YYYY').slice(8) }} </small></span>
                                        <span v-else class="pt-1">{{ reminder.name }} <small>
                                            <br /> {{ moment(reminder.reminder_date).format('HH:mma DD MMM YYYY') }} </small></span>
                                        <span v-if="moment(reminder.reminder_date).isAfter()" class="text-xl font-weight-regular text-success">
                                            <small>({{ moment(reminder.reminder_date).fromNow() }})</small>
                                        </span>
                                        <span v-else class="text-xl font-weight-regular text-danger">
                                            <small>({{ moment(reminder.reminder_date).fromNow() }})</small>
                                        </span>
                                        <br />
                                        <sup class="text-muted text-gray-200">(Reminder Group: {{ reminderProjects.find(project => project.id === reminder.project_id).name }})</sup> 
                                        <br />
                                        <button class="btn btn-sm btn-info mr-2">Snooze</button> <button class="btn btn-sm btn-danger" @click="stopReminder(reminder)">Stop</button>
                                    </div>
                                </div>

                                <div class="row col-md-12 mobile-hidden">
                                    <div class="col col-md-2">                  
                                    <span v-for="file in files.filter(file => file.id == (reminderProjects.find(project => project.id === reminder.project_id).fileId))" :key="file.id">
                                        <span class="btn btn-sm btn-success mb-2 py-0 px-1 mr-2 mt-2">{{ file.fileNo }} / {{ file.fileYear }}</span>
                                    </span>
                                    </div>
                                    <div class="col col-md-8">  
                                        <span v-if="moment(reminder.reminder_date).format('HH:mma DD MMM YYYY').includes('00:00am')">{{ reminder.name }} <small>@ {{ moment(reminder.reminder_date).format('HH:mma DD MMM YYYY').slice(8) }} </small></span>
                                        <span v-else>{{ reminder.name }} <small>@ {{ moment(reminder.reminder_date).format('HH:mma DD MMM YYYY') }} </small></span>
                                        <span v-if="moment(reminder.reminder_date).isAfter()" class="text-xl font-weight-regular text-success">
                                            <small>({{ moment(reminder.reminder_date).fromNow() }})</small>
                                        </span>
                                        <span v-else class="text-xl font-weight-regular text-danger">
                                            <small>({{ moment(reminder.reminder_date).fromNow() }})</small>
                                        </span>
                                        <br />
                                        <sup class="text-muted text-gray-200">(Reminder Group: {{ reminderProjects.find(project => project.id === reminder.project_id).name }})</sup> 
                                    </div>
                                    <div class="col-md-2 flex-row-reverse mt-2">
                                        <button class="btn btn-sm btn-info mr-2">Snooze</button> <button class="btn btn-sm btn-danger mr-2" @click="stopReminder(reminder)">Stop</button>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="modal-footer mobile-show justify-content-center">
                            <button type="button" v-if="reminders.length > 1" class="btn btn-lg btn-primary" @click="stopReminders">Stop All Reminder(s)</button>
                            <button type="button" v-if="reminders.length > 1" class="btn btn-lg btn-secondary" data-dismiss="modal">Snooze All (show @ next 5mins)</button>
                    </div>
                    <div class="modal-footer mobile-hidden">
                    <button type="button" v-if="reminders.length > 1" class="btn btn-lg btn-primary" @click="stopReminders">Stop All Reminder(s)</button>
                    <button type="button" v-if="reminders.length > 1" class="btn btn-lg btn-secondary" data-dismiss="modal">Snooze All (show @ next 5mins)</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Minimized state -->
        <div v-else class="minimized-modal d-block py-0 my-0" @click="toggleMinimize">
            <div class="modal-dialog modal-xl modal-dialog-centered py-0 my-0" role="document">
                <div class="modal-content py-0 my-0">
                    <div class="modal-header bg-warning p-2 my-0">
                        <h5 style="font-size: 14px" class="modal-title" id="reminderModalLabel"><i class="fa fa-lg fa-clock pr-2"></i> <b>{{ reminders.length }}</b> Reminder(s) </h5>
                        
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" title="Close this">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Custom modal for logout options -->
        <div v-if="showLogoutWithTimerOptionsModal" class="modal" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="reminderModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h5 class="modal-title text-white"><i class="fa fa-lg fa-user pr-2 text-white"></i> User Logout </h5>
                    </div>
                    <div class="modal-body mobile-show">
                        <div class="row m-2 p-2 flex-row-reverse">
                            <button v-if="activeTimer" class="py-4 btn btn-info btn-lg mb-2 w-100 font-weight-bold" @click="stopAndLogout">Stop Timer & Logout</button>
                            <button v-if="activeTimer" class="py-4 btn btn-secondary btn-lg mb-2 w-100 font-weight-bold" @click="keepRunningAndLogout">Keep Timer Running & Logout</button>
                            <button v-else class="py-4 btn btn-secondary btn-lg mb-2 w-100 font-weight-bold" @click="keepRunningAndLogout">Logout Now</button>
                            <button class="py-4 btn btn-warning btn-lg mb-2 w-100 font-weight-bold" @click="cancelLogout">Cancel</button>
                        </div>                        
                    </div>
                    <div class="modal-body mobile-hidden">
                        <div class="row m-2 p-2 flex-row-reverse">
                            <p>
                                <button v-if="activeTimer" class="btn btn-info btn-lg mr-2" @click="stopAndLogout">Stop Timer & Logout</button>
                                <button v-if="activeTimer" class="btn btn-secondary btn-lg mr-2" @click="keepRunningAndLogout">Keep Timer Running & Logout</button>
                                <button v-else class="btn btn-secondary btn-lg mr-2" @click="keepRunningAndLogout">Logout Now</button>
                                <button class="btn btn-warning btn-lg mr-2" @click="cancelLogout">Cancel</button>
                            </p>
                        </div>
                        <div class="row my-2 px-2">
                            <p>Active Timer: {{ activeTimer }} </p><br />
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</template>

<script>
    // Vue.use(InstantSearch);
    import algoliasearch from 'algoliasearch/lite';
    // import 'instantsearch.css/themes/satellite-min.css';
    import 'instantsearch.css/themes/algolia-min.css';
    import Modal from './Modal.vue';
    import TimerNotification from './TimerNotification.vue';
    import moment from 'moment';

    export default {
        // props: ['user'],
        props: ['currentFileId', 'counter', 'timer_projects'],
        components: {
            // AisInstantSearch,
            // AisSearchBox, 
            Modal,
            TimerNotification
        },
        mounted() {

            this.getNotifications();
            this.getNotificationsFileStatus();
            // this.loadCurrentUser();
            // this.startReminderInterval();

            // Temporary this is working
            Echo.channel(`channel`)
                // .listen(".App.Events.Hello", (data) => {
                .listen('.examplee', (data) => {
                    // alert("Loading New Channel");
                    console.log("New TODO Created", data);
                    this.getNotifications();
                    this.playSound3();
                    // setInterval(this.playSound1(), 1000);

                    console.log("New File Status Created");
                    this.getNotificationsFileStatus();
                    // this.playSound3();
                })
                .subscribed(() => {
                    // alert("Notification Loading...");
                    console.log("Echo => Connected HELLO channel!");
                })
                ;

            // this.getNotifications();
            
            // // 2nd try
            // Echo.channel(`todo-channel`)
            //     .listen('.todoactivities', (e) => {
            //         console.log("Todo listened", e);
            //     })
            //     // .listen('.exampleeee', (data) => {
            //     //     // alert("Loading New Channel");
            //     //     console.log("Todo listened", data);
            //     // })
            //     ;

            // console.log("mounted Component");
            // setInterval(this.getNotifications(), 60000);

            // Tempo hide for internal 
            // this.interval = setInterval(function() {
            //     this.getNotifications();
            //     this.getNotificationsFileStatus();

            // }.bind(this), 60000);

            setInterval(this.getNow, 1000);

            console.log('First time calling reminder...');
                    axios.get('/api/reminders/due', {
                        params: {
                            user_id: this.$userId
                        }
                    })
                    .then(response => {
                        // this.reminders = response.data;
                    const remindersArray = Object.values(response.data);

                    // Now you can use array methods like sort()
                    remindersArray.sort((a, b) => a.days_before - b.days_before);

                    this.reminders = remindersArray;

                    if (this.reminders.length > 0) {
                        this.playSound1();
                        $('#reminderModal').modal('show'); // Show the modal
                        
                    }
                    });
                    
        },
        data() {
            return {
                unreadnotifications: {},
                // unreadnotificationsFileStatus: {},
                unreadnotificationsFileStatus: [],
                // timestamp: ""
                timestampTime: "",
                timestampDate: "",
                searchClient: algoliasearch(
                    'S6UN7IS8FB',
                    '752385fd4f6d62167324fee0ecc2a2cc'
                    // '9e05fed6ad5db39de100ab908f3ff096',
                ),
                isModalVisible: false,
                isModalTimerVisible: false,
                user: '',
                roles: [],
                name: '',

                soundurl : 'http://soundbible.com/mp3/analog-watch-alarm_daniel-simion.mp3',
                $refs: {},
                hovered: false,
                hoveredIndex: null,     
                
                // Reminders
                reminders: [],
                files: [],
                file: {
                    id: '',
                    fileNo: '',
                    fileYear: ''
                },
                // isLoading: true,
                reminderProjects: [],
                minimized: false,
                reminderInterval: null,
                showLogoutWithTimerOptionsModal: false,
                // activeTimer: {},
                activeTimer: false,
                // activeTimer: {
                //     valid: false // You can set other properties as needed
                // }

            }
        },
        created() {
            axios.get('/api/user').then( (response) => {
                this.user = response.data;
                console.log(response);
            });
            
            axios.get('/api/fileless').then( (response) => {
                const filesArray = Object.values(response.data.data);
                this.files = filesArray;
                // this.files = response.data;
                // this.isLoading = false;  // Add this line
                console.log(response);
            });
            
            axios.get('/api/reminder_projects').then( (response) => {
                const reminderProjectsArray = Object.values(response.data);
                this.reminderProjects = reminderProjectsArray;
                // this.reminderProjects = response.data;
                console.log(response);
            });

                setInterval(() => {
                if(!this.minimized) {
                    console.log('Minimize is false, reminder running...');
                    axios.get('/api/reminders/due', {
                        params: {
                    user_id: this.$userId
                    }
                    })
                    .then(response => {
                        // this.reminders = response.data;
                    const remindersArray = Object.values(response.data);

                    // Now you can use array methods like sort()
                    remindersArray.sort((a, b) => a.days_before - b.days_before);

                    this.reminders = remindersArray;

                    if (this.reminders.length > 0) {
                        this.playSound1();
                        $('#reminderModal').modal('show'); // Show the modal
                        // this.$modal.show('reminderModal', { draggable: true });
                        // this.playSound3();
                        
                    }
                    })
                    .catch(error => {
                    console.log(error.response);
                });
                }
                }, 300000); // 60,000 milliseconds = 1 minute

                this.checkActiveTimer();
            
    },
        methods: {
            setHoveredIndex(index) {
                this.hoveredIndex = index;
            },
                isHovered(index) {
                return this.hoveredIndex === index;
            },
            getNotifications() {
                axios.get('/api/unreadNotifications')
                // axios.get('/api/todos')
                    // .then(({data}) => {
                    //     this.unreadnotifications = data.data || data;
                    // })
                    .then(({data}) => {
                        this.unreadnotifications = data.data || data;
                    })
                    .catch((errors) => {
                        console.log(errors)
                    });
            },
            
            getNotificationsFileStatus() {
                axios.get('/api/unreadNotificationsFileStatus')
                    .then(({data}) => {
                        this.unreadnotificationsFileStatus = data.data || data;
                    })
                    .catch((errors) => {
                        console.log(errors)
                    });
            },

            markAsRead() {
                axios.get('/api/markAsRead').then((response) => {
                    // location.reload();
                    alert('All notifications marked as read');
                        this.getNotifications();

                }).catch((errors) => {
                    console.log(errors)
                })
            },
            
            // For Scout Search
            searchQuery() {
                axios.get('/api/searchQuery').then((response) => {
                    // location.reload();
                    alert('Serach Activating');
                        // this.getNotifications();

                }).catch((errors) => {
                    console.log(errors)
                })
            },
            
            markAsReadFileStatus() {
                axios.get('/api/markAsReadFileStatus').then((response) => {
                    location.reload();
                }).catch((errors) => {
                    console.log(errors)
                })
            },
            
            markOneAsReadFileStatus(unread) {
                const data = {
                    id: unread.id
                };
                const self = unread;
                
                // axios.put('/api/unreadNotifications/' + this.id)
                axios.put('/api/markOneAsReadFileStatus/' + data.id)
                    .then((response) => {
                        // alert('Notification marked as read');
                        this.getNotificationsFileStatus();
                        console.log(response.data);
                        // location.reload();
                    }).catch((errors) => {
                        console.log(errors)
                    })
            },
            
            markOneAsRead(unread) {

                // axios.post('/api/markAsRead/' + notification.id).then((response) => {

                const data = {
                    id: unread.id
                };
                const self = unread;
                
                // axios.put('/api/unreadNotifications/' + this.id)
                axios.put('/api/markOneAsRead/' + data.id)
                    .then((response) => {
                        // alert('Notification marked as read');
                        this.getNotifications();
                        console.log(response.data);
                        // location.reload();
                    }).catch((errors) => {
                        console.log(errors)
                    })
            },

            getNow: function() {
                    const today = new Date();
                    // const date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
                    // const date = today.getDate()+'-'+(today.getMonth()+1)+'-'+today.getFullYear();
                    const date = today.toLocaleString('en-us',{day:'numeric', month:'short', year:'numeric'});
                    // const time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds(); ORI
                    const time = (today.getHours()<10?'0':'') + today.getHours() + ":" + (today.getMinutes()<10?'0':'') + today.getMinutes() + ":" + (today.getSeconds()<10?'0':'') + today.getSeconds();
                    // (date.getMinutes()<10?'0':'') + date.getMinutes()
                    // const dateTime = time +' | '+ date;
                    this.timestampTime = time; 
                    this.timestampDate = date;
                    // const dateTime = time +' | '+ date;
                    // this.timestamp = dateTime;
            },

            checkActiveTimer () {
                axios.get('/api/project/timers/active')
                        .then(response => { 
                            if (response.data.id !== undefined) {
                                this.activeTimer = true;
                            } else {
                                this.activeTimer = false;
                            }


                            // this.activeTimer = response.data.id;
                            console.log(response);
                        })
                        .catch(error => {
                            console.log(error);
                        });
            },

            handleLogout() {
                // Check if there is an active timer
                axios.get('/api/project/timers/active')
                    .then(response => {
                        if (response.data.id !== undefined) {
                            if (confirm("You have an active timer. Do you want to stop it before logging out?")) {
                                const timerId = response.data.id;
                                axios.post(`/api/timer_projects/${timerId}/timers/stop2`)
                                    .then(response => {
                                        // Timer stopped, proceed with logout
                                        if (confirm("Do you want to logout now?")) {
                                            axios.post("/logout")
                                                .then(response => { 
                                                    this.$router.go('/login');
                                                    console.log(response);
                                                })
                                        }
                                    })
                                    .catch(error => {
                                        console.log(error);
                                    });
                            } else if (confirm("Are you sure you want to log out with the active timer running?")) {
                                axios.post("/logout")
                                    .then(response => { 
                                        this.$router.go('/login');
                                        console.log(response);
                                    })
                                    .catch(error => {
                                        console.log(error);
                                    });
                            }
                            // // There is an active timer, prompt the user to stop it
                            // if (confirm("You have an active timer. Do you want to stop it before logging out?")) {
                            //     // If the user chooses to stop the timer, stop the timer and proceed with logout
                            //     // this.stopTimer(response.data.id);
                            //     const timerId = response.data.id;
                            //     axios.post(`/api/timer_projects/${timerId}/timers/stop2`)
                            //         .then(response => {
                            //             axios.post("/logout")
                            //                 .then(response => { 
                            //                     this.$router.go('/login');
                            //                     console.log(response);
                            //                 })
                            //         })
                            //         .catch(error => {
                            //             console.log(error);
                            //         });
                            // }
                        } else {
                            // No active timer, proceed with logout
                            if (confirm("Are you sure you want to log out?")) {
                                    axios.post("/logout").then(response => { 
                                        this.$router.go('/login');
                                        console.log(response);
                                    })
                                    .catch(error => {
                                        console.log(error);
                                    });
                            }
                        }
                    })
                    .catch(({ response }) => {
                        if (response) {
                            this.errors = response.data.errors;
                        } else {
                            console.error("Error: Response object is undefined.");
                        }
                    });
            },
            
            // handleLogout() {
            //     if(confirm("Are you sure you want to log out?")) {
            //         axios.post("/logout").then(response => { 
            //             this.$router.go('/login');
            //             console.log(response);
            //         })
            //         .catch(error => {
            //             console.log(error);
            //         });
            //     }
            // },
            showModal() {
                this.isModalVisible = true;
            },
            
            closeModal() {
                this.isModalVisible = false;
            },
            showModalTimer() {
                this.isModalTimerVisible = true;
            },
            
            closeModalTimer() {
                this.isModalTimerVisible = false;
            },

            // loadCurrentUser() {
            //     axios.get('/api/user')
            //     .then(({data}) => {
            //         this.user = data.data;
            //         }).catch((errors) => {
            //             console.log(errors)
            //         });
            //         console.log(this.user);
            // },

            checkRole() {
                return this.user.isAdmin;
                // console.log('checking role..');
            },

            playSound1() {
                
                var audioFile = new Audio('../../mp3/mixkit-software-interface-start-2574.wav');
                audioFile.play();
            },
            playSound3() {
                
                var audioFile = new Audio('../../mp3/mixkit-atm-cash-machine-key-press-2841.wav');
                audioFile.play();
            },
            playSound2() {
                // var audio = new Audio(data.soundurl);
                // const data = { soundurl('http://soundbible.com/mp3/analog-watch-alarm_daniel-simion.mp3') };
                // var audio = new Audio(soundurl);
                // audio.play();
                var audioFile = new Audio('../../mp3/sms-alert-3-daniel_simon.mp3');
                audioFile.play();
            },
            
            isMoreThanTenDaysAgo(created_at) {
                // Use moment.js to check if the date is more than 10 days ago
                return moment().diff(created_at, 'days') > 10;
            },
            
            todoIsMoreThanTenDaysAgo(created_at) {
                // Use moment.js to check if the date is more than 10 days ago
                return moment().diff(created_at, 'days') > 10;
            },

            gotoFileTodo() {
                this.$store.commit('setHighlightTodoTab', true);
                this.$router.push('/file/1/filedetails#v-pills-settings-tab');
            },

            stopReminders() {
                this.reminders.forEach(reminder => {
                    axios.post(`/api/reminders/${reminder.id}/stop`)
                    .then(response => {
                        console.log(`Reminder ${reminder.id} stopped`);
                    })
                    .catch(error => {
                        console.error(`Error stopping reminder ${reminder.id}:`, error);
                    });
                });

                alert('All the Reminder(s) has been stopped.');
                $('#reminderModal').modal('hide'); // Hide the modal after all reminders are stopped

                },

            stopReminder(reminder) {
                if (confirm("Are you sure to stop the selected reminder?")) {
                    axios.post(`/api/reminders/${reminder.id}/stop`)
                    .then(response => {
                        console.log(`Reminder ${reminder.id} stopped`);

                        // Remove the reminder from the reminders array
                        const index = this.reminders.findIndex(r => r.id === reminder.id);
                        if (index !== -1) {
                        this.reminders.splice(index, 1);
                        }
                    })
                    .catch(error => {
                        console.error(`Error stopping reminder ${reminder.id}:`, error);
                    });

                }
            },

            closeReminderModal() {
                this.$modal.hide('reminderModal');
            },
            toggleMinimize() {
                this.minimized = false;
                console.log('resumed to maximize');               
                    
                    axios.get('/api/reminders/due', {
                        params: {
                    user_id: this.$userId
                    }
                    })
                    .then(response => {
                        // this.reminders = response.data;
                    const remindersArray = Object.values(response.data);

                    // Now you can use array methods like sort()
                    remindersArray.sort((a, b) => a.days_before - b.days_before);

                    this.reminders = remindersArray;

                    if (this.reminders.length > 0) {
                        this.playSound1();
                        $('#reminderModal').modal('show'); // Show the modal
                        // this.$modal.show('reminderModal', { draggable: true });
                        // this.playSound3();
                        
                    }
                    })
                    .catch(error => {
                    console.log(error.response);
                });
                

                // this.minimized = !this.minimized;
                // if (!this.minimized) {
                //     this.startReminderInterval();
                // }
                // console.log('resumed to maximize');
            },

            toggleMaximize() {
                this.minimized = true;
                // this.getDueReminders(); // Call the method to get due reminders immediately
                console.log('Minimize reminder. Status now: ', this.minimized);
                
                // this.minimized = !this.minimized;
                // if (this.minimized) {
                //     this.stopReminderInterval();
                // }
                // console.log('Minimize reminder. Status now: ', this.minimized);
            },

            // toggleMinimize() {
            //     this.minimized = !this.minimized;
            //     console.log('resumed to maximize');
            //     // startReminderInterval();

            // },
            
            // toggleMaximize() {
            //     this.minimized = !this.minimized;
            //     console.log('Minimize reminder. Status now: ', this.minimized);

            //     // this.stopReminderInterval();

            // },

            // startReminderInterval() {
            //     console.log('Current value of minimized:', this.minimized); // Add this line to check the current value of minimized
            //     reminderInterval = setInterval(() => {
            //         if (!this.minimized) {
            //             console.log('Reminder interval is running because minimized is false'); // Add this line to check if the condition is being evaluated correctly
            //             this.getDueReminders();
            //         }
            //     }, 10000);

            //     // reminderInterval = setInterval(() => {
            //     //     if (!this.minimized) {
            //     //         this.getDueReminders();
            //     //     }
            //     // }, 10000);
            // },

            // stopReminderInterval() {
            //     clearInterval(this.reminderInterval);
            //     // clearInterval(reminderInterval);
            //     // clearInterval(this.$data.reminderInterval);
            // },

            // getDueReminders() {
            //     if(!this.minimized) {
            //         axios.get('/api/reminders/due', {
            //             params: {
            //                 user_id: this.$userId
            //             }
            //         })
            //         .then(response => {
            //             const remindersArray = Object.values(response.data);
            //             remindersArray.sort((a, b) => a.days_before - b.days_before);
            //             this.reminders = remindersArray;
            //             if (this.reminders.length > 0) {
            //                 this.playSound1();
            //                 $('#reminderModal').modal('show');
            //             }
            //         })
            //         .catch(error => {
            //             console.log(error.response);
            //         });
            //     }
            // },
            handleLogoutWithTimerOptions() {
                this.showLogoutWithTimerOptionsModal = true;
                
                this.$nextTick(() => {
                    this.checkActiveTimer();
                    // Further operations after the modal state is updated
                    $('#logoutModal').modal('show');
                });

                // this.checkActiveTimer();
                // this.showLogoutWithTimerOptionsModal = true;
                // this.$nextTick(() => {
                //     $('#logoutModal').modal('show');
                // });
                // // $('#logoutModal').modal('show');
            },
            stopAndLogout() {
            // Stop the timer and then logout
            // ... (code to stop the timer and logout)
            axios.get('/api/project/timers/active')
                    .then(response => {
                                        
                    // If the user chooses to stop the timer, stop the timer and proceed with logout
                    // this.stopTimer(response.data.id);
                    const timerId = response.data.id;
                    axios.post(`/api/timer_projects/${timerId}/timers/stop2`)
                        .then(response => {
                            axios.post("/logout")
                                .then(response => { 
                                    this.$router.go('/login');
                                    console.log(response);
                                })
                        })
                        .catch(error => {
                            console.log(error);
                        });
                
            
                
                        axios.post("/logout").then(response => { 
                            this.$router.go('/login');
                            console.log(response);
                        })
                        .catch(error => {
                            console.log(error);
                        });                           
                            
                        })
                        .catch(({ response }) => {
                            if (response) {
                                this.errors = response.data.errors;
                            } else {
                                console.error("Error: Response object is undefined.");
                            }
                        });
                this.showLogoutWithTimerOptionsModal = false;
                $('#logoutModal').modal('hide');
            },
            keepRunningAndLogout() {
                // Logout without stopping the timer
                // ... (code to logout without stopping the timer)
                axios.post("/logout").then(response => { 
                    this.$router.go('/login');
                    console.log(response);
                })
                .catch(error => {
                    console.log(error);
                });
                this.showLogoutWithTimerOptionsModal = false;
                $('#logoutModal').modal('hide');
            },
            cancelLogout() {
            // Cancel the logout
            // ... (code to cancel the logout)
                this.showLogoutWithTimerOptionsModal = false;
                $('#logoutModal').modal('hide');
            }

        },
        watch: {
            minimized(value) {
                if (value) {
                $('#reminderModal').modal('hide');
                } else {
                $('#reminderModal').modal('show');
                }
                // if (value) {
                // $('.modal-backdrop').hide();
                // } else {
                // $('.modal-backdrop').show();
                // }
            }
        },
        computed: {

            groupedNotifications() {
                // this.unread = getNotificationsFileStatus();
                if (!this.unreadnotificationsFileStatus) {
                    return [];
                }

                const groups = {};

                this.unreadnotificationsFileStatus.forEach((notification) => {
                    const key = `${notification.data.fileNo}-${notification.data.fileYear}`;

                    if (!groups[key]) {
                    groups[key] = [];
                    }

                    groups[key].push(notification);
                });

                return Object.values(groups);
            },

            isActiveFile() {
                // return this.unread.data.todo.fileId === this.currentFileId;
                // return this.unreadnotifications.filter(unread => unread.data.todo.fileId === this.currentFileId);
            },

            modalTitleReminder () {
                return this.isEdit ? "Update Reminder" : "Add Reminder"
            },
            
        },
        // beforeDestroy() {
        //     this.toggleMinimize();
        // },
    };
</script>
<style scoped>
    .file-btn, .file-btn-status {
        background-color: green;
    }
    .file-btn.active, .file-btn-status.active {
        background-color: #626ebe;
        cursor: none;
        pointer-events: none;
        /* display: block; */
    }
    .gotofilepage-btn.active {
        background-color: #626ebe;
        display: none;
    }
    .gototodopage-btn.active {
        background-color: #626ebe;
        display: none;
    }
    /* .gotofile-btn .active { */
    /* .active {
        background-color: #154389 !important;
        cursor: none;
        pointer-events: none;
        color: #FFF !important;
        display: none;
    } */
    .active:hover {
        /* background-color: #CCCCCC !important; */
        background-color: #ffc107 !important;
        /* border-color: #ffc107 !important; */
        /* border: 1px #383838 !important; */
    }
    .dropdown-menu {
        max-height: 880px;
        overflow-y: auto;
    }

    .fixed-width-item {
        min-width: 100px; /* Adjust the value based on your needs */
        box-sizing: border-box; /* Include padding and border in the element's total width */
    }

    .active-btn {
        /* Add your styles for the active button here */
        background-color: #a9943f; /* Change this color as per your design */
    }

    .legasis-header {
        /* position: fixed;
        top: 0px;
        left: 0px;
        padding: 0px;
        z-index: 10000000 !important; */
    }
    
    .minimized-modal {
        position: fixed;
        bottom: 0px;
        right: 0px;
        background-color: transparent;
        border: 0px solid #ccc;
        padding: 0px;
        cursor: pointer;
        z-index: 10000000 !important;
        opacity: 0.9;
    }

    .minimized-modal i {
        font-size: 14px;
    }

    .reminderModal {
        z-index: 10000000 !important;
    }

    /* .modal-backdrop.show, .modal-backdrop {
        z-index: -1 !important;
    } */
    @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@500&display=swap');

</style>