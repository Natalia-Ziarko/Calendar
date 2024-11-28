<?php

const NOT_EXISTING_EVENT_ID = 0;
const TESTING_EVENT_ID = 2;

const AT_COUNTRY_ID = 1;

const COMPET_GAME_EVENT_ID = 1;
const FRIEND_GAME_EVENT_ID = 2;

const VENUE_ID = 1;

const TEAM_1_ID = 1;
const TEAM_2_ID = 2;

const FOOTBALL_SPORT_ID = 1;
const ICE_HOCKEY_SPORT_ID = 2;

const LINE = '----------------------------------------------------------------';

function echo_test_message($test, $function_name) {
    echo '<br><br>' . $test . ' <b>' . $function_name . '()</b> [' . date("Y-m-d g:i:s:u") . ']<br><br>&emsp;';
}