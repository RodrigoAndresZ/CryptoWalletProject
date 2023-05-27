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


    public function addCoinInWallet(string $walletId, Coin $coin): void
    {
        $wallet = $this->cache->get('wallet_' . $walletId);
        $coinPosition = 0;
        $esta = false;

        foreach ($wallet['coins'] as $coinCache) {
            if ($coinCache['coinId'] == $coin->getName()) {
                $Amount = $coinCache['amount'] + $coin->getAmount();
                $coin->setAmount($Amount);
                $wallet['coins'][$coinPosition] = $coin->getJson();
                $esta = true;
            }
            $coinPosition++;
        }
        if (!$esta) {
            $wallet = new Wallet($walletId);
            $wallet->addCoin($coin);
            $wallet['coins'][$coinPosition] = $coin->getJson();
            $esta = true;
        }

        $this->cache->put('wallet_' . $walletId, $wallet);
    }
}
