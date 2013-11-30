<?php
require_once __DIR__ . '/../vendor/autoload.php';

use OAuth\Common\Storage\Session;
use OAuth\Common\Consumer\Credentials;
use OAuth\Common\Http\Uri\Uri;

/*
 * Session storage
 */
$storage = new Session();

/*
 * Setup your credentials for the API requests.
 * Visit http://services.blackboxgps.com for information on obtaining your API Client
 */
$credentials = new Credentials(
    '<key>',
    '<secret>',
    '<redirect_uri>'
);

/*
 * Instantiate the Beacon service using the credentials, http client and storage mechanism for the token
 */
$serviceFactory = new \OAuth\ServiceFactory();
$beaconService = $serviceFactory->createService('beacon', $credentials, $storage, array(), new Uri("http://services.blackboxgps.com/"));

if (!empty($_GET['code'])) {
    try {
        // This was a callback request from Beacon, get the token
        $beaconService->requestAccessToken($_GET['code']);

        // Get users and print their basic info
        print "<pre>";
        print "<h1>Calling '/api/users'</h1>";

        $result = json_decode($beaconService->request('/api/users'), true);
        if (count($result['users']) > 0) {
            $users = $result['users'];
            print sprintf("Total users: %d\n", count($users));

            for($i = 0; $i < count($users); $i++) {
                print sprintf("%d: %s %s, %s\n", $i+1, $users[$i]['first_name'], $users[$i]['last_name'], $users[$i]['username']);
            }
        }

        $rnd_user = $users[array_rand($users)];
        print sprintf("<h1>Calling '/api/users/{id}' for %s</h1>", $rnd_user['username']);

        $result = json_decode($beaconService->request('/api/users/'.$rnd_user['id']), true);
        print_r($rnd_user);

        // Get all groups and print their names
        print "<h1>Calling '/api/groups'</h1>";
        $result = json_decode($beaconService->request('/api/groups'), true);
        if (count($result['groups']) > 0) {
            $groups = $result['groups'];
            print sprintf("Total groups: %d\n", count($groups));

            print_r(buildTree($groups, 2));
        }

        print "</pre>";
    } catch(Exception $e) {
        print "Exception: ".$e->getMessage();
    }

} elseif (!empty($_GET['go']) && $_GET['go'] === 'go') {
    $url = $beaconService->getAuthorizationUri();
    header('Location: ' . $url);
} else {
    $uriFactory = new \OAuth\Common\Http\Uri\UriFactory();
    $currentUri = $uriFactory->createFromSuperGlobalArray($_SERVER);
    $currentUri->setQuery('');

    $url = $currentUri->getRelativeUri() . '?go=go';
    print sprintf('<a href="%s">Login with your BlackBox GPS account!</a>', $url);
}

function buildTree(array &$elements, $parentId = 0)
{
    $branch = array();

    foreach ($elements as $element) {
        if ($element['pid'] == $parentId) {
            $children = buildTree($elements, $element['id']);
            if ($children) {
                $element['children'] = $children;
            }
            $branch[$element['id']] = $element;
            unset($elements[$element['id']]);
        }
    }
    return $branch;
}
