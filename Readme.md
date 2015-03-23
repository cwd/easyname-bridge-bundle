Easyname PHP SDK Bridge for Symfony >=2.3
=========================================

Install:
```
composer require cwd/easyname-bridge-bundle dev-master
```

Config:
```
cwd_easyname_bridge:
    url: "https://api.easyname.com"
    user:
        id: 1234
        email: user@host.de
    api:
        key: 'asdfasdfasdf'
        authentication_salt: 'asdsadf%%asdfasdfasdf'
        signing_salt: 'asdfasdfasdfasdf'
    debug: false
```

Attention: if you have an % in your salt, you have to escape it with an additional % !

Usage:
```
$service = $this->container->get('cwd_easyname_bridge.service');
$result = $service->getDomain(12345);
```
