<?php

function hasRole(string $role): bool {
    return isset($_SESSION['roles']) && in_array($role, $_SESSION['roles'], true);
}

function isAdmin(): bool {
    return hasRole('ADMIN');
}

function isAnalista(): bool {
    return hasRole('ANALISTA');
}

