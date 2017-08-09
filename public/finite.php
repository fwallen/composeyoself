<?php

require_once('../vendor/autoload.php');

use Finite\StateMachine\StateMachine;
use Finite\State\State;
use Finite\State\StateInterface;
use Packages\Lib\StatefulObject;

$stateMachine = new StateMachine();

//Create some states
$stateMachine->addState(new State('state_1',StateInterface::TYPE_INITIAL));
$stateMachine->addState(new State('state_2',StateInterface::TYPE_NORMAL));
$stateMachine->addState(new State('state_3',StateInterface::TYPE_FINAL));

//Define transitions
$stateMachine->addTransition('to_state_2','state_1','state_2');
$stateMachine->addTransition('to_state_3','state_2','state_3');
$stateMachine->addTransition('jump_to_state_3','state_1','state_3');
$stateMachine->addTransition('back_to_state_1','state_3','state_1');

//Now create a state machine with our StatefulObject
$object = new StatefulObject();
$stateMachine->setObject($object);
$stateMachine->initialize();

//Give it a name
$stateMachine->setGraph('Transitioning States');

dump('Current State: '.$stateMachine->getCurrentState());
dump('Can jump to \'state_3\'? '.($stateMachine->can('jump_to_state_3') ? 'Yes' :'No'));

dump('Transitioning to state_2....');
$stateMachine->apply('to_state_2');

dump('Current State: '.$stateMachine->getCurrentState());
dump('Can jump back to \'state_1\'? '.($stateMachine->can('back_to_state_1') ? 'Yes' :'No'));

//Can't transition to state_3 using 'jump_to_state_3'
dump('Can jump to \'state_3\'? '.($stateMachine->can('jump_to_state_3') ? 'Yes' :'No'));
dump('Can transition to \'state_3\'? '.($stateMachine->can('to_state_3') ? 'Yes' :'No'));

dump('Transitioning to state_3...');
$stateMachine->apply('to_state_3');

dump('Current State: '.$stateMachine->getCurrentState());
dump('Can jump back to \'state_1\'? '.($stateMachine->can('back_to_state_1') ? 'Yes' :'No'));

