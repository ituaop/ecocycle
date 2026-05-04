<?php

namespace Src\Recycling\User\Domain\Entities;

use Src\Recycling\User\Domain\ValueObjects\UserEmail;
use Src\Recycling\User\Domain\ValueObjects\UserId;
use Src\Recycling\User\Domain\ValueObjects\UserLevel;
use Src\Recycling\User\Domain\ValueObjects\UserName;
use Src\Recycling\User\Domain\ValueObjects\UserTotalPoints;
use Src\Recycling\User\Domain\ValueObjects\UserUserName;

class User
{
    private UserId          $id;
    private UserName        $name;
    private UserUserName    $username;
    private UserEmail       $email;
    private UserLevel       $level;
    private UserTotalPoints $totalPoints;

    public function __construct(
        UserId          $id,
        UserName        $name,
        UserUserName    $username,
        UserEmail       $email,
        UserLevel       $level,
        UserTotalPoints $totalPoints
    ) {
        $this->id          = $id;
        $this->name        = $name;
        $this->username    = $username;
        $this->email       = $email;
        $this->level       = $level;
        $this->totalPoints = $totalPoints;
    }

    public function getId(): UserId               { return $this->id; }
    public function getIdValue(): string          { return $this->id->value(); }

    public function getName(): UserName           { return $this->name; }
    public function getNameValue(): string        { return $this->name->value(); }

    public function getUsername(): UserUserName   { return $this->username; }
    public function getUsernameValue(): string    { return $this->username->value(); }

    public function getEmail(): UserEmail         { return $this->email; }
    public function getEmailValue(): string       { return $this->email->value(); }

    public function getLevel(): UserLevel         { return $this->level; }
    public function getLevelValue(): string       { return $this->level->value(); }

    public function getTotalPoints(): UserTotalPoints { return $this->totalPoints; }
    public function getTotalPointsValue(): int        { return $this->totalPoints->value(); }

    public function toArray(): array
    {
        return [
            'id'           => $this->getIdValue(),
            'name'         => $this->getNameValue(),
            'username'     => $this->getUsernameValue(),
            'email'        => $this->getEmailValue(),
            'level'        => $this->getLevelValue(),
            'total_points' => $this->getTotalPointsValue(),
        ];
    }
}
