<?php

declare(strict_types=1);

namespace App\Enums;

enum RoleEnum: String {
    CASE SUPER_ADMIN = "Super Admin";
    CASE RH = "Ressource Humaine";
    CASE DC = "Depositaire Comptable";
    CASE SSE = "SSE";
    CASE SMF = "SMF";
    CASE SPSS = "SPSS";
    CASE CHEFFERIE = "Chefferie";
    CASE USER = "User";
}