<?php

declare(strict_types=1);

const ALLOW_METHODS = ['GET', 'POST'];
const INDEX_URI = '';
const INDEX_ROUNTE = 'home';

function normalizeUri(string $uri): string
{
    $uri = strtok($uri, '?');
    $uri = strtolower(trim($uri, '/'));
    return $uri == INDEX_URI ? INDEX_ROUNTE : $uri;
}

function notFound()
{
    http_response_code(404);
    echo "404 Not Found";
    exit;
}

function badRequest(string $message = 'Bad request'): void
{
    http_response_code(400);
    echo $message;
    exit;
}

function getFilePath(string $uri, string $method): string
{
    return ROUTE_DIR . '/' . normalizeUri($uri) . '_' . strtolower($method) . '.php';
}

function dispatch(string $uri, string $method): void
{
    // 1) Normalize the URI
    $uri = normalizeUri($uri);
    
    // 2) Handle GET and POST requests
    if (!in_array(strtoupper($method), ALLOW_METHODS)) {
        notFound();
    }
    
    // 3) Link to php files
    $filePath = getFilePath($uri, $method); // ค้นหาไฟล์แบบมี _get หรือ _post 
    $filePathNoMethod = ROUTE_DIR . '/' . $uri . '.php'; // ค้นหาไฟล์แบบชื่อตรงๆ ไม่มี _get หรือ _post

    if (file_exists($filePath)) {
        include($filePath);
        return;
    } elseif (file_exists($filePathNoMethod)) {
        // เพิ่มเงื่อนไขให้มารองรับชื่อไฟล์ธรรมดา เช่น events.php, event_form.php
        include($filePathNoMethod);
        return;
    } else {
        notFound();
    }
}