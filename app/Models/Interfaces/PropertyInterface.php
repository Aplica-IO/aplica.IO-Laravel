<?php

namespace App\Models\Interfaces;

Interface PropertyInterface
{
    public function index();
    public function show($id);
    public function store($data);
    public function update($id, $data);
    public function destroy($id);
}
