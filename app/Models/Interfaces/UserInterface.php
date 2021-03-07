<?php

namespace App\Models\Interfaces;

Interface UserInterface
{
    public function index($params);
    public function show($id);
    public function store($data);
    public function update($id, $data);
    public function destroy($id);
}
