<?php

test('The_homapage_is_accessible', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
    $response->assertViewIs('welcome');
});
test('The_test_page_is_accessible', function () {
    $response = $this->get('/test');

    $response->assertStatus(200);
    $response->assertViewIs('test');
    $response->assertSee('test content');
    $response->assertViewHas('title');
    $response->assertViewHas('content', 'test content');
    $response->assertViewHasAll(['title', 'content']);
    $response->assertSee('<h1>test</h1>', false);
});

