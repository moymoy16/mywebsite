<?php
function e(?string $value): string {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function url(string $path = ''): string {
    return rtrim(BASE_URL, '/') . '/' . ltrim($path, '/');
}

function redirect(string $path): void {
    header('Location: ' . url($path));
    exit;
}

function old(array $old, string $key, string $default = ''): string
{
    return htmlspecialchars($old[$key] ?? $default, ENT_QUOTES, 'UTF-8');
}

function upload_item_image(array $file): ?string
{
    // No file uploaded
    if (empty($file['name']) || $file['error'] === UPLOAD_ERR_NO_FILE) {
        return null;
    }

    if ($file['error'] !== UPLOAD_ERR_OK) {
        throw new \RuntimeException('Upload failed. Please try again.');
    }

    // Max 2 MB
    if ($file['size'] > 2 * 1024 * 1024) {
        throw new \RuntimeException('Image must be smaller than 2 MB.');
    }

    // Check real MIME type (not the browser-supplied one)
    $allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
    $finfo   = new \finfo(FILEINFO_MIME_TYPE);
    $mime    = $finfo->file($file['tmp_name']);

    if (!isset($allowed[$mime])) {
        throw new \RuntimeException('Only JPG, PNG, or WebP images are allowed.');
    }

    $ext      = $allowed[$mime];
    $filename = bin2hex(random_bytes(16)) . '.' . $ext;
    $destDir  = BASE_PATH . '/public/uploads/items/';
    $destPath = $destDir . $filename;

    if (!is_dir($destDir)) {
        mkdir($destDir, 0755, true);
    }

    if (!move_uploaded_file($file['tmp_name'], $destPath)) {
        throw new \RuntimeException('Could not save the uploaded image.');
    }

    return $filename;
}

/**
 * Delete an item image file. Silent if it doesn't exist.
 */
function delete_item_image(?string $filename): void
{
    if (!$filename) return;
    $path = BASE_PATH . '/public/uploads/items/' . $filename;
    if (is_file($path)) {
        @unlink($path);
    }
}

/**
 * Build a public URL for an item image, with fallback.
 */
function item_image_url(?string $filename): string
{
    if ($filename && is_file(BASE_PATH . '/public/uploads/items/' . $filename)) {
        return '/uploads/items/' . rawurlencode($filename);
    }
    return ''; // caller decides fallback
}