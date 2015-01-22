<?php

namespace Foolz\Cache\Storage;

class Db extends \Foolz\Cache\Storage
{
    /**
     * Returns the configuration of the storage engine
     *
     * @return  \Foolz\Cache\Config\Db
     */
    public function getConfig()
    {
        return $this->config;
    }

    public function get($key)
    {
        $result = $this->getConfig()
            ->getConnection()
            ->createQueryBuilder()
            ->select('*')
            ->from($this->getConfig()->getTable(), 't')
            ->where('key = :key')
            ->setParameter(':key', $key)
            ->execute()
            ->fetch();

        if (!$result || ($result['expiration'] > 0 && $result['created'] + $result['expiration'] > time())) {
            return \Foolz\Cache\Void::forge();
        }

        return $result['value'];
    }

    public function set($key, $value, $expiration)
    {
        $qb = $this->getConfig()
            ->getConnection()
            ->createQueryBuilder();

        $affected = $qb->update($this->getConfig()->getTable())
            ->set('value', ':value')
            ->set('created', time())
            ->set('expiration', ':expiration')
            ->where('key = :key')
            ->setParameter(':key', $key)
            ->setParameter(':value', $value)
            ->setParameter(':expiration', $expiration)
            ->execute();

        if (!$affected) {
            try {
                $this->getConfig()
                    ->getConnection()
                    ->insert($this->getConfig()->getTable(), [
                        'key' => $key,
                        'value' => $value,
                        'created' => time(),
                        'expiration' => $expiration
                    ]);
            } catch (\Doctrine\DBAL\DBALException $e) {
                // it was inserted before we could finish. Due to how caching usually works, we leave it alone
            }
        }
    }

    public function delete($key)
    {
        $this->getConfig()
            ->getConnection()
            ->createQueryBuilder()
            ->delete($this->getConfig()->getTable())
            ->where('key = :key')
            ->setParameter(':key', $key)
            ->execute();
    }

    public function flush()
    {
        $this->getConfig()
            ->getConnection()
            ->createQueryBuilder()
            ->delete($this->getConfig()->getTable())
            ->execute();
    }
}
