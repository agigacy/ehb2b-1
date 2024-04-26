<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'is_agent' => $this->is_agent,
            // 'roles' => $this->roles->pluck('name'), // 获取角色名称数组
            'roles' => $this->roles, // 获取角色名称数组
            'groups' => $this->groups,
            'permissions' => $this->getAllPermissions()->pluck('name'), // 获取所有权限名称数组
        ];
    }
}
