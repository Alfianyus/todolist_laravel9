<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodolistControllerTest extends TestCase
{
    public function testTodoList()
    {
        $this->withSession([
            "user"=>"Yuska",
            "todolist"=>[
                [
                    "id"=>"1",
                    "todo"=>"Ysk"
                ],
                [
                    "id"=>"2",
                    "todo"=>"al"
                ]
            ]

        ])->get('/todolist')
            ->assertSeeText("1")
            ->assertSeeText("Ysk")
            ->assertSeeText("2")
            ->assertSeeText("al");
    }

    public function testAddTodoFailed()
    {
        $this->withSession([
            "user"=>"yuska"
        ])->post("/todolist",[])
            ->assertSeeText("Todo is required");
    }

    public function testAddTodoSuccess()
    {
        $this->withSession([
            "user"=>"yuska"
        ])->post("/todolist",[
            "todo"=>"al"
        ])->assertRedirect("/todolist");
    }

    public function testRemoveTodoList()
    {
        $this->withSession([
            "user"=>"yuska",
            "todolist"=>[
                [
                    "id"=>"1",
                    "todo"=>"yuska"
                ],
                [
                    "id"=>"2",
                    "todo"=>"al"
                ]
            ]
        ])->post("/todolist/1/delete")
            ->assertRedirect("/todolist");
    }
}
