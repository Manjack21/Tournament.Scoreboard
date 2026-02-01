<?php

namespace Tournament;



class Configuration
{
    public const string DATABASE_FILE = "../data/tournaments.db";
    public const string LOG_FILE = "../data/log.txt";
    public const array API_KEYS = [
        "EsB6nMTXviD1tVn2AxiL"
    ];
    public const array PUBLIC_URLS = [
        'GET/api.php/tournaments'
    ];
}

\Analog::handler(\Analog\Handler\File::init(Configuration::LOG_FILE));
