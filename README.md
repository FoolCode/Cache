Heavy duty caching package, meant for serious sites needing serious caching powers.

Requires PHP 5.4.

#### The gist

You must give a configuration object to an instance of cache.

```php
<?php
Cache::instantiate(Config::forgeApc());
Cache::item('test')->set($value);
Cache::item('test')->get();
?>
```

And this is all if you use APC.

## Storages

Currently bundled storages:

* APC
* Memcached
* DB (Doctrine DBAL) (permanent storage, great for configurations)
* Dummy (always returns not found)
* File
* Volatile (uses PHP Arrays and gets wiped on the end of the process)

## Formats

We added several formats that might sound useless. We need the formats to be compatible with extraneous software.

Currently bundled formats:

* ArrayJson (stores the json wrapped as array)
* ObjectJson (stores the json wrapped as object)
* SmartJson (uses an object to store the kind of json)
* Plain
* Serialized

## Configuration

You can create a new configuration in two ways:

```php
<?php
$config = Config::forgeMemcached();
// or
$config = new \Foolz\Cache\Config\Memcached;
?>
```

IDE hints will appear, helping you configuring the storage. You can also look in the folder `classes/Foolz/Cache/Config` for the configurations available.

#### Base configuration methods

* __$config->getStorage()__

	Returns the name of the storage

* __$config->setFormat($format)__

	Set one of the formats: `array_json`, `object_json`, `smart_json`, `plain`, `serialized`.

* __$config->getFormat()

	Returns the name of the format

* __$config->setPrefix($prefix)__

	Set a prefix for the stored items

* __$config->getPrefix()__

	Get the prefix for the stored items

* __$config->setThrow($bool = false)__

	Pass true if you want failed cache GETs to throw an exception. False if you prefer a fallback value. False by default.

* __$config->getThrow()__

	True if GETs will throw an exception, false otherwise.


## Instantiation

The Cache package features an instance system.

* __Cache::instantiate(\Foolz\Cache\Config $config, $instance_name = 'default')__

	Create a new link for the caching backend.

* __Cache::destroy($instance_name)__

	Destroys the link for the cache backend.

* __$item = Cache::forge($instance_name = 'default')__

	Returns an instance of the link.

* __$item = Cache::item($key, $instance_name = 'default)__

	Creates an instance paired with a key.

* __$item->getConfig()__

	Returns the configuration object.

* __$item->getEngine()__

	Returns the raw storage engine class.

* __$item->getKey()__

	Returns the key for the item.

* __$item->set($value, $expiration = 0)__

	Sets a value. Expiration is seconds from now.

* __$item->get()__

	Returns the stored value. Returns \Foolz\Cache\Void if the value is not found. Throws \OutOfBoundsException if the Throws setting is enabled and the value is not found.

* __$item->delete()__

	Delete a stored value.

* __$item->flush()__

	Deletes all the entries in the engine.