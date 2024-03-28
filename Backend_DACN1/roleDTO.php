<?php

class RoleDTO
{
    public $id;
    public $role_name;

    public function fromJson($jsonData)
    {
        if (isset($jsonData['id'])) {
            $this->id = $jsonData['id'];
        }
        if (isset($jsonData['role_name'])) {
            $this->role_name = $jsonData['role_name'];
        }
    }

    public function toJson()
    {
        return json_encode([
            'id' => $this->id,
            'role_name' => $this->role_name,
        ]);
    }
}
