<?php

namespace App\Models;

/**
 * Eloquent User model は Infrastructure 層に移動しました。
 * 後方互換のためのエイリアスです。
 *
 * @see \App\Infrastructure\Persistence\Eloquent\UserModel
 */
class User extends \App\Infrastructure\Persistence\Eloquent\UserModel {}
