<?php
if(!defined('IN_MYBB'))
{
    exit;
}

$plugins->add_hook('global_start', 'noprivatesupport_hook_start');
$plugins->add_hook('error', 'noprivatesupport_hook_error');

function noprivatesupport_info()
{
    return
    [
        'name' => 'NoPrivateSupport',
        'description' => 'Show an explanation to low-post users trying to write emails or PMs.',
        'website' => 'https://github.com/Siguza/NoPrivateSupport',
        'author' => 'Siguza',
        'authorsite' => 'https://siguza.net/',
        'version' => '1.0',
    ];
}

function noprivatesupport_hook_start()
{
    global $lang;
    $lang->load('noprivatesupport');
}

function noprivatesupport_hook_error($error)
{
    global $lang, $mybb;
    if((($_SERVER['SCRIPT_FILENAME'] == MYBB_ROOT.'private.php' && $mybb->input['action'] == 'send' && $mybb->usergroup['canusepms'] == 1) || ($_SERVER['SCRIPT_FILENAME'] == MYBB_ROOT.'member.php' && $mybb->input['action'] == 'emailuser' && $mybb->user['uid'] != 0)))
    {
        $error = $lang->noprivatesupport_msg;
        file_put_contents('test.log', print_r($GLOBALS['mybb'], true));
    }
    return $error;
}
