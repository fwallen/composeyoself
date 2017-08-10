<?php

require_once('../vendor/autoload.php');

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\Options;

//options values to set
$args = [
//    'host'     => 'localhost',
    'password' => 'foo',
    'username' => 'Joe',
//        'port' => 3306
];

//Create the resolver and set up requirements, validations
$resolver = new OptionsResolver();

//Define required options
$resolver->setRequired(['username', 'password', 'host']);

//Set Type validation
$resolver->setAllowedTypes('username', 'string')
    ->setAllowedTypes('password', 'string')
    ->setAllowedTypes('host', 'string');

//Create a normalizer
$resolver->setNormalizer('host', function(Options $options, $value) {
    if (substr($value, 0, 7) !== 'http://') {
        return 'http://' . $value;
    }

    return $value;
});

//This defines an option, but does not make it required.
$resolver->setDefined('port');
$resolver->setAllowedTypes('port', ['null', 'int']);

dump('Options not set yet.','Is "host" missing? ' . ($resolver->isMissing('host') ? 'Yes' : 'No'));
dump('Defined Options:', $resolver->getDefinedOptions());

dump('Setting some defaults.');
//These can be required options, but the default satisfies the requirement
$defaults = [
    'host' => '127.0.0.1',
];
$resolver->setDefaults($defaults);
dump($defaults);


dump('Is host missing? ' . ($resolver->isMissing('host') ? 'Yes' : 'No'));
dump('Is port defined? ' . ($resolver->isDefined('port') ? 'Yes' : 'No'));
dump('Setting Options by passing our arguments');

//These will be the options that 'pass'
$options = $resolver->resolve($args);


//Now we can safely set values
$newOptions = [
    'host'     => $options['host'],
    'password' => $options['password'],
    'username' => $options['username'],

    //In this case, since we didn't force the option of 'port' we have to check
    //Note that if $options['port'] is null, isset will return false
    'port'     => isset($options['port']) ? $options['port'] : 3306,
];

//Our new validated options
dump($newOptions);