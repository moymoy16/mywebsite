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

/**
 * Resolve the uploads directory for both local (public/uploads)
 * and InfinityFree (uploads at web root).
 */
function uploads_path(): string
{
    if (is_dir(BASE_PATH . '/public/uploads')) {
        return BASE_PATH . '/public/uploads';
    }
    return BASE_PATH . '/uploads';
}

// ═══ ITEM IMAGES ═══

function upload_item_image(array $file): ?string
{
    if (empty($file['name']) || $file['error'] === UPLOAD_ERR_NO_FILE) {
        return null;
    }

    if ($file['error'] !== UPLOAD_ERR_OK) {
        throw new \RuntimeException('Upload failed. Please try again.');
    }

    if ($file['size'] > 2 * 1024 * 1024) {
        throw new \RuntimeException('Image must be smaller than 2 MB.');
    }

    $allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
    $finfo   = new \finfo(FILEINFO_MIME_TYPE);
    $mime    = $finfo->file($file['tmp_name']);

    if (!isset($allowed[$mime])) {
        throw new \RuntimeException('Only JPG, PNG, or WebP images are allowed.');
    }

    $ext      = $allowed[$mime];
    $filename = bin2hex(random_bytes(16)) . '.' . $ext;

    // ═══ FIXED: use uploads_path() ═══
    $destDir  = uploads_path() . '/items/';
    $destPath = $destDir . $filename;

    if (!is_dir($destDir)) {
        mkdir($destDir, 0755, true);
    }

    if (!move_uploaded_file($file['tmp_name'], $destPath)) {
        throw new \RuntimeException('Could not save the uploaded image.');
    }

    return $filename;
}

function delete_item_image(?string $filename): void
{
    if (!$filename) return;
    $path = uploads_path() . '/items/' . $filename;
    if (is_file($path)) {
        @unlink($path);
    }
}

function item_image_url(?string $filename): string
{
    if ($filename && is_file(uploads_path() . '/items/' . $filename)) {
        return '/uploads/items/' . rawurlencode($filename);
    }
    return '';
}

// ═══ PROFILE PROOFS ═══

function upload_profile_proof(array $file): ?string
{
    if (empty($file['name']) || $file['error'] === UPLOAD_ERR_NO_FILE) {
        return null;
    }

    if ($file['error'] !== UPLOAD_ERR_OK) {
        throw new \RuntimeException('Upload failed. Please try again.');
    }

    if ($file['size'] > 3 * 1024 * 1024) {
        throw new \RuntimeException('Proof image must be smaller than 3 MB.');
    }

    $allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
    $finfo   = new \finfo(FILEINFO_MIME_TYPE);
    $mime    = $finfo->file($file['tmp_name']);

    if (!isset($allowed[$mime])) {
        throw new \RuntimeException('Proof must be a JPG, PNG, or WebP image.');
    }

    $ext      = $allowed[$mime];
    $filename = bin2hex(random_bytes(16)) . '.' . $ext;

    // ═══ FIXED: use uploads_path() ═══
    $dir  = uploads_path() . '/proofs/';
    $path = $dir . $filename;

    if (!is_dir($dir)) mkdir($dir, 0755, true);

    if (!move_uploaded_file($file['tmp_name'], $path)) {
        throw new \RuntimeException('Could not save the proof image.');
    }

    return $filename;
}

function proof_image_url(?string $filename): string
{
    if ($filename && is_file(uploads_path() . '/proofs/' . $filename)) {
        return '/uploads/proofs/' . rawurlencode($filename);
    }
    return '';
}