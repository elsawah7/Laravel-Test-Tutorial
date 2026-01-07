<?php

test('that_users_route_return_users', function () {

    $response = $this->get('/users');
    $response->assertStatus(200);
    $response->assertJsonIsArray();
    $response->assertJsonCount(3);
    $response->assertJsonFragment(['name' => 'John Doe']);
});

test('that_get_user_by_id_route_return_user', function () {
    $response = $this->get('/users/1');
    $response->assertStatus(200);
    $response->assertJsonIsObject();
    $response->assertJsonFragment(['name' => 'John Doe']);
});

test('that_non_existent_user_by_id_route_return_404', function () {
    $response = $this->get('/users/8');
    $response->assertStatus(404);
});

test('that_post_user_route_can_create_new_user', function () {
    $response = $this->post('/users', [
        'name' => 'zezo',
        'age' => 22
    ]);
    $response->assertStatus(201);
    $response->assertJsonIsObject();
});

test('that_put_user_route_can_update_user', function () {
    $response = $this->put('/users/1', [
        'name' => 'elsawah',
        'age' => 22
    ]);
    $response->assertStatus(200);
    $response->assertJsonIsObject();
});

test('that_delete_user_route_can_delete_user', function () {
    $response = $this->delete('/users/3');
    $response->assertStatus(204);
});
