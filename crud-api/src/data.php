<?php

function loadData(string $dataFile): array
{
    if (!file_exists($dataFile)) {
        return ['nextId' => 1, 'users' => []];
    }

    $content = file_get_contents($dataFile);
    if ($content === false || trim($content) === '') {
        return ['nextId' => 1, 'users' => []];
    }

    $decoded = json_decode($content, true);
    if (!is_array($decoded)) {
        return ['nextId' => 1, 'users' => []];
    }

    if (isset($decoded['users']) && is_array($decoded['users'])) {
        return $decoded;
    }

    if (array_is_list($decoded)) {
        $users = [];
        $nextId = 1;

        foreach ($decoded as $item) {
            if (!is_array($item)) {
                continue;
            }

            $id = isset($item['id']) ? (int) $item['id'] : $nextId;
            $nextId = max($nextId, $id + 1);

            $users[] = [
                'id' => $id,
                'name' => $item['name'] ?? '',
                'age' => isset($item['age']) ? (int) $item['age'] : 0,
                'email' => $item['email'] ?? '',
            ];
        }

        return ['nextId' => $nextId, 'users' => $users];
    }

    return ['nextId' => 1, 'users' => []];
}

function saveData(string $dataFile, array $data): void
{
    if (!isset($data['users']) || !is_array($data['users'])) {
        $data = ['nextId' => 1, 'users' => []];
    }

    file_put_contents($dataFile, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

function insertUser(string $dataFile, array $user): array
{
    $data = loadData($dataFile);

    $id = $data['nextId'] ?? 1;
    $data['nextId'] = $id + 1;

    $user['id'] = $id;
    $data['users'][] = $user;

    saveData($dataFile, $data);

    return $user;
}

function updateUser(string $dataFile, int $id, array $fields): ?array
{
    $data = loadData($dataFile);

    foreach ($data['users'] as $index => $user) {
        if ($user['id'] === $id) {
            $data['users'][$index] = array_merge($user, $fields);
            saveData($dataFile, $data);
            return $data['users'][$index];
        }
    }

    return null;
}

function deleteUser(string $dataFile, int $id): ?array
{
    $data = loadData($dataFile);

    foreach ($data['users'] as $index => $user) {
        if ($user['id'] === $id) {
            array_splice($data['users'], $index, 1);
            saveData($dataFile, $data);
            return $user;
        }
    }

    return null;
}