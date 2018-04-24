<?php

$container = $app->getContainer();

$container->set('GuildList', [
    '501st Bataillon' => '/api/guilds/15066/units/',
    'Imperial Bataillon' => '/api/guilds/21878/units/',
    '104th Bataillon' => '/api/guilds/18908/units/',
    //'41st Bataillon' => '/api/guilds/3233/units/',
    'B2TF Bataillon' => '/api/guilds/25014/units/',
    'Outerrim10 Bataillon' => '/api/guilds/25118/units/',
    '313th Bataillon' => '/api/guilds/31673/units/',
    //'43rd Bataillon' => '/api/guilds/32210/units/',
    '442nd Bataillon' => '/api/guilds/16040/units/',
    '18th Bataillon' => '/api/guilds/32283/units/',
]);

$container->set(Twig_Environment::class, function () {
    $loader = new Twig_Loader_Filesystem(__DIR__ . '/../src/Views');
    return new Twig_Environment($loader);
});

$container->set(\Bataillon\Persistance\FileHandler::class, new \Bataillon\Persistance\FileHandler());

$container->set(\Bataillon\Renderers\MemberProfile::class,
    new \Bataillon\Renderers\MemberProfile($container->get(Twig_Environment::class))
);

$container->set(\Bataillon\Clients\SWGoH::class, new \Bataillon\Clients\SWGoH(
    new \GuzzleHttp\Client([
        'base_uri' => 'https://swgoh.gg',
    ])
));

$container->set(\Bataillon\Controller\UpdateController::class, new \Bataillon\Controller\UpdateController(
    $container->get(\Bataillon\Clients\SWGoH::class),
    $container->get(\Bataillon\Persistance\FileHandler::class),
    $container->get('GuildList')
));

$container->set(\Bataillon\Mapper\CharactersMapper::class, new \Bataillon\Mapper\CharactersMapper(
    $container->get(\Bataillon\Persistance\FileHandler::class)
));

$container->set(\Bataillon\Mapper\MemberMapper::class, new \Bataillon\Mapper\MemberMapper());