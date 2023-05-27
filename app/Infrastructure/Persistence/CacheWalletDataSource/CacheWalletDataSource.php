<?php

namespace App\Infrastructure\Persistence\CacheWalletDataSource;

use App\Application\DataSource\WalletDataSource;
use App\Domain\Coin;
use App\Domain\Wallet;
use Illuminate\Contracts\Cache\Repository as CacheRepository;

class CacheWalletDataSource implements WalletDataSource
{
    protected $cache;

    public function __construct(CacheRepository $cache)
    {
        $this->cache = $cache;
    }

    public function createWallet(): ?string
    {
        for ($i = 0; $i <= 100; $i++) {
            if (!$this->cache->has('wallet_' . $i)) {
                $wallet = new Wallet('wallet_' . $i);
                $this->cache->put('wallet_' . $i, $wallet);
                return 'wallet_' . $i;
            }
        }
        return null;
    }

    public function findWalletById(string $wallet_id): ?Wallet
    {
        if ($this->cache->has('wallet_' . $wallet_id)) {
            return $this->cache->get('wallet_' . $wallet_id);
        }
        return null;
    }


    public function addCoinToWallet(string $wallet_id, Coin $coin): void
    {
        $wallet = $this->cache->get('wallet_' . $wallet_id);
        $coinPosition = 0;
        $esta = false;

        foreach ($wallet['coins'] as $coinCache) {
            if ($coinCache['name'] == $coin->getName()) {
                $Amount = $coinCache['amount'] + $coin->getAmount();
                $coin->setAmount($Amount);
                $wallet['coins'][$coinPosition] = $coin->getJson();
                $esta = true;
            }
            $coinPosition++;
        }
        if (!$esta) {
            $wallet = new Wallet($wallet_id);
            $wallet->addCoin($coin);
            $wallet['coins'][$coinPosition] = $coin->getJson();
            $esta = true;
        }

        $this->cache->put('wallet_' . $wallet_id, $wallet);
    }


    public function SellCoinWallet(string $wallet_id,Coin $coin, float $newUsdValue,string $amountUsd): void
    {
        if ($this->cache->has('wallet_' . $wallet_id)) {
            $wallet = $this->cache->get('wallet_' . $wallet_id);
            $coinPosition = 0;
            foreach ($wallet['coins'] as $coinItem) {
                if (strcmp($coinItem['name'], $coin->getName()) == 0) {
                    $wallet['coins'][$coinPosition]['amount'] -= floatval($amountUsd) / $newUsdValue;
                    $this->cache->put('wallet_' . $wallet_id, $wallet);
                    break;
                }
                $coinPosition++;
            }
        }
    }
}
