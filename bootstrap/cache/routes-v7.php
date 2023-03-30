<?php

/*
|--------------------------------------------------------------------------
| Load The Cached Routes
|--------------------------------------------------------------------------
|
| Here we will decode and unserialize the RouteCollection instance that
| holds all of the route information for an application. This allows
| us to instantaneously load the entire route map into the router.
|
*/

app('router')->setCompiledRoutes(
    array (
  'compiled' => 
  array (
    0 => false,
    1 => 
    array (
      '/_debugbar/open' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'debugbar.openhandler',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/_debugbar/assets/stylesheets' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'debugbar.assets.css',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/_debugbar/assets/javascript' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'debugbar.assets.js',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/2fa/confirm' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => '2fa.confirm',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::mO8T1KTPVuJQYkOQ',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/livewire/upload-file' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'livewire.upload-file',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/livewire/livewire.js' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::stwJlHUg431Bds1t',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/livewire/livewire.js.map' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::yBxkPakXs7t0M3lP',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/broadcasting/auth' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::iRyQcTQvnCFvQWaI',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'POST' => 1,
            'HEAD' => 2,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/member/login' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.v1.',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/member/register' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.v1.registerJwt',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/member/history_by_type' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.v1.generated::RiIq5pbJAzfZL3oO',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/member' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.v1.generated::ZPf57ycGSjnmwAPf',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/member/balance' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.v1.generated::GMDUp0B2jb3HSesb',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/member/last-bet-win' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.v1.generated::OYWMDsvzBEzYdKea',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/member/last_bet' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.v1.generated::yFLgzgm43aX44sOv',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/member/last_win' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.v1.generated::xpFSrqC90Gu9YbZO',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/member/history' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.v1.generated::deGXgK7v1zzaNJXD',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/member/refresh' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.v1.generated::H5tcI2O1fWtjjW31',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/member/logout' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.v1.generated::2szyp8fK6KmXAAR8',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/member/change-password' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.v1.generated::0b99JTePahBy9x93',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/member/bonus-referal' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.v1.generated::bpU6kGesDe4bSnNi',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/member/deposit/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.v1.generated::6sIYBc7Tidj7iaPL',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/member/bonus/setting-bonus-freebet' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.v1.generated::m9JKyMdL1vrmnetA',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/member/bonus/freebet-list' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.v1.generated::6noqMitwF075CjZg',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/member/bonus/bonus-freebet-giveup' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.v1.generated::S0zbolNpsB71YS1J',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/member/bonus/setting-bonus-deposit' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.v1.generated::ebwl0qzCw8UY3Snw',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/member/bonus/deposit-list' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.v1.generated::ERl5gqDvrwN5Wfue',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/member/bonus/bonus-deposit-giveup' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.v1.generated::IKSiXwdy7js5rZjY',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/member/withdraw/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.v1.generated::olCbtJP7QI9B9lhu',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/member/win_lose_status' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.v1.generated::yV6nMWKNz46RiXSx',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/member/deposit_withdraw_status' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.v1.generated::TGCOo52xosu2CpMh',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/member/memo/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.v1.generated::YsYMwFenjv5lZpa9',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/member/memo/inbox' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.v1.generated::B3tZXyAKH83CzuDe',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/member/memo/sent' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.v1.generated::xHl0LJIL0M2HTDjf',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/member/memo/read' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.v1.generated::31xeX316spCG82vX',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/member/memo/reply' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.v1.generated::2uFh94aV82rBexul',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/member/memo/notify-memo' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.v1.generated::XlYtdiC7oXnTF7zl',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/member/statement' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.v1.generated::aBpkDCzSt2iFAEBz',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/member/bonus' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.v1.generated::czTtKcEm604hd8Vg',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/member/statement-depo-wd' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.v1.generated::PO7T86cH2HBxgnkH',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/member/create_rekening_member' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.v1.generated::RNlLdse9OIFTdOv2',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/member/list_rekening_member' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.v1.generated::y4wElsvRaOnVXJeB',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/member/list_rek_agent' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.v1.generated::emB02my4eyUrAixp',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/member/rekening_member_wd' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.v1.generated::r8JI872oFlaEFqgO',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/member/update_rekening_member' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.v1.generated::SYkoqscEBoNwH0ed',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/member/referral/code' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.v1.generated::msaNjwSI9iKRb5BG',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/member/referral/list' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.v1.generated::4fUT1aOjzhMOw0BN',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/cashback' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.v1.generated::lggbtr9yjrRa32Gp',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/daily-referal' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.v1.generated::mjsalB7bh9e1XyLT',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/bank/destination' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.v1.generated::wkKl04imYhRWTE4a',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/etc/broadcast' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.v1.generated::lhZlci7teiq5hdng',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/etc/apk' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.v1.generated::pxeqU8HWSPVH2xae',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/etc/livechat' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.v1.generated::l73iksTD3PRyhcX2',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/etc/whatsapp' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.v1.generated::pqqFQgAj4tR9Nw5N',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/etc/multimedia' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.v1.generated::RDtHRsUWipHzOe9m',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/bank' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.v1.generated::37P3IjMLXDHAbcPU',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/bank/bank_wd' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.v1.generated::k0JXJ5Yzm6olgtw2',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/bank/availability' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.v1.generated::HsNq4up4EkJWZVN5',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/cms/banner_promo_bonus' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.v1.generated::bZDkC6eDQPpwc4fY',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/contact/message/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.v1.generated::PWNjOniTFtPxcn6G',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/maintenance' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.v1.generated::any8vaw7OWSwMu2L',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/maintenance/force-logout' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.v1.generated::NSp3ZExEfsxlKAWD',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/maintenance-website' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.v1.generated::vN3TSHp2Elr3nEYE',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/setting/rolling-value' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.v1.generated::S8WtoSufX6CwFe6p',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/setting/limit' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.v1.generated::J0aC7JDazV4bSd6k',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/setting/list_togel' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.v1.generated::mzrbo22ZB9aeGW9N',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/setting/web_page' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.v1.generated::uAQFuWNij1grlKze',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/setting/footer_tag' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.v1.generated::Payr9lGPgm84KT3b',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/setting/whatsapp_url' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.v1.generated::CZZqogvs2Y4SVsi8',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/setting/social' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.v1.generated::QN8L9aaTBZY1HUUe',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/setting/seo' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.v1.generated::6btKCWMoSjDiIJ6r',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/endpoint/bet' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/endpoint/betSpade' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.generated::BGudsoK2jQuGdGHL',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/endpoint/get_history_pragmatic' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.generated::eBEeKOk6hiaf0mW6',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/endpoint/round' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.generated::IMM6JAsQi5SpSdPy',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/endpoint/bet_pragmatic' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.generated::G9wx2xEbQvas0Iyn',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/endpoint/result_pragmatic' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.generated::q9lKJqDzP31HAE4n',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/endpoint/cancel_bet_pragmatic' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.generated::03TQ1crABtJiSlGx',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/endpoint/result_habanero' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.generated::pVSN0mNDfkFM2Igb',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/endpoint/bet_joker' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.generated::qSHGdWR0woxJDRc8',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/endpoint/settle_bet_joker' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.generated::Qp8n9Rs46tOYWnNb',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/endpoint/cancel_bet_joker' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.generated::g1rL8KklD7QL0Nq1',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/endpoint/balance' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.generated::9PFkw3DJq7Ur1kZW',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/endpoint/result' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.generated::rO9Vf8caaFZBVK8o',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/endpoint/transaction_joker' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.generated::sHCkCZTco97SwoVg',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/endpoint/withdraw_joker' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.generated::X5Zr3Dr9HlUryxRL',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/endpoint/deposit_joker' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.generated::ONSZ6PTFMTBKwKXZ',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/endpoint/resultSpade' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.generated::hMGuBhetQxsTXnuf',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/endpoint/bet_playtech' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.generated::XFhNlqvKC2mTjYMn',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/endpoint/cancel_bet_playtech' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.generated::KhoYI6EEGmuGzcpa',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/endpoint/result_playtech' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.generated::NOaVE9Zkj6sS0f5l',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/endpoint/get_history_spade_gaming' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.generated::0YSZuBRrEfwg6Nw6',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/endpoint/transfer-in-out' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.generated::gAOrpFS7JsREIFZk',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/endpoint/bet_gameHall' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.generated::9RFiJymo62Ap3D21',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/endpoint/result_gameHall' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.generated::7qITRqOagqFiPM9k',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/endpoint/debit' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.generated::p8uhVfWGZ2Y90cAj',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/endpoint/credit' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.generated::K7ArA1wL8OJudwpH',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/endpoint/detail_spade_gaming' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.generated::GWA1cspiOTTXiuNE',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/endpoint/settingGames' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.generated::b8eOHEGWfIUmzoRg',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/endpoint/provider' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.generated::QwVbDrWGLBWzsCYH',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/endpoint/paitoEight' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.generated::vz5xJxBPbjumpQQB',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/endpoint/paitoAll' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.generated::Q9teHbvOJVNJ8HIk',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'POST' => 1,
            'HEAD' => 2,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/endpoint/shio' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.generated::06nZyd2AQKSdOICe',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/endpoint/list_out_result' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.generated::dDmGGweMVxX4pPLE',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/endpoint/pasaran' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.generated::Jtchl5Ti09nAyNgv',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/endpoint/allPasaran' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.generated::JqVbn1x24IFvvxPq',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/endpoint/dreamBooks' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.generated::gyQsUeJolNG0UWrm',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/endpoint/globalSetting' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.generated::m4s9C0Out8dhBdK6',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/endpoint/rules' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.generated::jkNnv1Uuq88Abl3W',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/endpoint/getDetailTransaksi' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.generated::aqOvDU4aaZRO5LpB',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/endpoint/storeTogel' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.generated::Cpu3kve2reFqw6w5',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/ionx/deduct-player-balance' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.generated::v0Kx1WWtf8qOS16p',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/ionx/get-player-balance' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.generated::ekKUcqn6UnC3dzH7',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/ionx/rollback-player-balance' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.generated::WE19LedrfPF6hLmE',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/ionx/Insert-running-bet' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.generated::0rtqCFfQppcQKz7D',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/ionx/settle-bet' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.generated::Hx36Yo9zD6mXiRHl',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/ionx/insert-game-announcement' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.generated::AXFkpUqVlkwgZQk4',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::YgOA0bzFX45qIv41',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/event-balance-test' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::ogLf1KadxXDULVS6',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/event-memo-test' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::8UvxpP4PpyMFgoNA',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/impersonate/leave' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'impersonate.leave',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
    ),
    2 => 
    array (
      0 => '{^(?|/_debugbar/c(?|lockwork/([^/]++)(*:39)|ache/([^/]++)(?:/([^/]++))?(*:73))|/livewire/message/([^/]++)(*:107)|/([^/]++)/livewire/message/([^/]++)(*:150)|/livewire/preview\\-file/([^/]++)(*:190)|/api/(?|v1/(?|member/memo/detail/([^/]++)(*:239)|cms/(?|website\\-content/([^/]++)(*:279)|image\\-contents/([^/]++)(*:311)|game\\-content/([^/]++)(*:341))|setting/referral_game/([^/]++)(*:380))|endpoint/getDetailTransaksiTogel/([^/]++)(*:430))|/impersonate/take/([^/]++)(?:/([^/]++))?(*:479))/?$}sDu',
    ),
    3 => 
    array (
      39 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'debugbar.clockwork',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      73 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'debugbar.cache.delete',
            'tags' => NULL,
          ),
          1 => 
          array (
            0 => 'key',
            1 => 'tags',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      107 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'livewire.message',
          ),
          1 => 
          array (
            0 => 'name',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      150 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'livewire.message-localized',
          ),
          1 => 
          array (
            0 => 'locale',
            1 => 'name',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      190 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'livewire.preview-file',
          ),
          1 => 
          array (
            0 => 'filename',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      239 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.v1.generated::LHJMu2gfGSYKOEpb',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      279 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.v1.generated::TNu1UNm196hESXFs',
          ),
          1 => 
          array (
            0 => 'slug',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      311 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.v1.generated::qEGzpLiWH1kCCQTE',
          ),
          1 => 
          array (
            0 => 'type',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      341 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.v1.generated::kpidY0FbuqKSrGKy',
          ),
          1 => 
          array (
            0 => 'slug',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      380 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.v1.generated::HJpH3gFpp1q4dJJp',
          ),
          1 => 
          array (
            0 => 'type',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      430 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.generated::xwjVVTxoVV31Z1Mo',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      479 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'impersonate',
            'guardName' => NULL,
          ),
          1 => 
          array (
            0 => 'id',
            1 => 'guardName',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => NULL,
          1 => NULL,
          2 => NULL,
          3 => NULL,
          4 => false,
          5 => false,
          6 => 0,
        ),
      ),
    ),
    4 => NULL,
  ),
  'attributes' => 
  array (
    'debugbar.openhandler' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => '_debugbar/open',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'Barryvdh\\Debugbar\\Middleware\\DebugbarEnabled',
        ),
        'uses' => 'Barryvdh\\Debugbar\\Controllers\\OpenHandlerController@handle',
        'as' => 'debugbar.openhandler',
        'controller' => 'Barryvdh\\Debugbar\\Controllers\\OpenHandlerController@handle',
        'namespace' => 'Barryvdh\\Debugbar\\Controllers',
        'prefix' => '_debugbar',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'debugbar.clockwork' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => '_debugbar/clockwork/{id}',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'Barryvdh\\Debugbar\\Middleware\\DebugbarEnabled',
        ),
        'uses' => 'Barryvdh\\Debugbar\\Controllers\\OpenHandlerController@clockwork',
        'as' => 'debugbar.clockwork',
        'controller' => 'Barryvdh\\Debugbar\\Controllers\\OpenHandlerController@clockwork',
        'namespace' => 'Barryvdh\\Debugbar\\Controllers',
        'prefix' => '_debugbar',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'debugbar.assets.css' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => '_debugbar/assets/stylesheets',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'Barryvdh\\Debugbar\\Middleware\\DebugbarEnabled',
        ),
        'uses' => 'Barryvdh\\Debugbar\\Controllers\\AssetController@css',
        'as' => 'debugbar.assets.css',
        'controller' => 'Barryvdh\\Debugbar\\Controllers\\AssetController@css',
        'namespace' => 'Barryvdh\\Debugbar\\Controllers',
        'prefix' => '_debugbar',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'debugbar.assets.js' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => '_debugbar/assets/javascript',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'Barryvdh\\Debugbar\\Middleware\\DebugbarEnabled',
        ),
        'uses' => 'Barryvdh\\Debugbar\\Controllers\\AssetController@js',
        'as' => 'debugbar.assets.js',
        'controller' => 'Barryvdh\\Debugbar\\Controllers\\AssetController@js',
        'namespace' => 'Barryvdh\\Debugbar\\Controllers',
        'prefix' => '_debugbar',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'debugbar.cache.delete' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => '_debugbar/cache/{key}/{tags?}',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'Barryvdh\\Debugbar\\Middleware\\DebugbarEnabled',
        ),
        'uses' => 'Barryvdh\\Debugbar\\Controllers\\CacheController@delete',
        'as' => 'debugbar.cache.delete',
        'controller' => 'Barryvdh\\Debugbar\\Controllers\\CacheController@delete',
        'namespace' => 'Barryvdh\\Debugbar\\Controllers',
        'prefix' => '_debugbar',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    '2fa.confirm' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => '2fa/confirm',
      'action' => 
      array (
        'uses' => 'DarkGhostHunter\\Laraguard\\Http\\Controllers\\Confirm2FACodeController@showConfirmForm',
        'controller' => 'DarkGhostHunter\\Laraguard\\Http\\Controllers\\Confirm2FACodeController@showConfirmForm',
        'middleware' => 
        array (
          0 => 'web',
        ),
        'as' => '2fa.confirm',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::mO8T1KTPVuJQYkOQ' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => '2fa/confirm',
      'action' => 
      array (
        'uses' => 'DarkGhostHunter\\Laraguard\\Http\\Controllers\\Confirm2FACodeController@confirm',
        'controller' => 'DarkGhostHunter\\Laraguard\\Http\\Controllers\\Confirm2FACodeController@confirm',
        'middleware' => 
        array (
          0 => 'web',
        ),
        'as' => 'generated::mO8T1KTPVuJQYkOQ',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'livewire.message' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'livewire/message/{name}',
      'action' => 
      array (
        'uses' => 'Livewire\\Controllers\\HttpConnectionHandler@__invoke',
        'controller' => 'Livewire\\Controllers\\HttpConnectionHandler',
        'as' => 'livewire.message',
        'middleware' => 
        array (
          0 => 'web',
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'livewire.message-localized' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => '{locale}/livewire/message/{name}',
      'action' => 
      array (
        'uses' => 'Livewire\\Controllers\\HttpConnectionHandler@__invoke',
        'controller' => 'Livewire\\Controllers\\HttpConnectionHandler',
        'as' => 'livewire.message-localized',
        'middleware' => 
        array (
          0 => 'web',
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'livewire.upload-file' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'livewire/upload-file',
      'action' => 
      array (
        'uses' => 'Livewire\\Controllers\\FileUploadHandler@handle',
        'controller' => 'Livewire\\Controllers\\FileUploadHandler@handle',
        'as' => 'livewire.upload-file',
        'middleware' => 
        array (
          0 => 'web',
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'livewire.preview-file' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'livewire/preview-file/{filename}',
      'action' => 
      array (
        'uses' => 'Livewire\\Controllers\\FilePreviewHandler@handle',
        'controller' => 'Livewire\\Controllers\\FilePreviewHandler@handle',
        'as' => 'livewire.preview-file',
        'middleware' => 
        array (
          0 => 'web',
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::stwJlHUg431Bds1t' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'livewire/livewire.js',
      'action' => 
      array (
        'uses' => 'Livewire\\Controllers\\LivewireJavaScriptAssets@source',
        'controller' => 'Livewire\\Controllers\\LivewireJavaScriptAssets@source',
        'as' => 'generated::stwJlHUg431Bds1t',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::yBxkPakXs7t0M3lP' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'livewire/livewire.js.map',
      'action' => 
      array (
        'uses' => 'Livewire\\Controllers\\LivewireJavaScriptAssets@maps',
        'controller' => 'Livewire\\Controllers\\LivewireJavaScriptAssets@maps',
        'as' => 'generated::yBxkPakXs7t0M3lP',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::iRyQcTQvnCFvQWaI' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'POST',
        2 => 'HEAD',
      ),
      'uri' => 'broadcasting/auth',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Broadcasting\\BroadcastController@authenticate',
        'controller' => '\\Illuminate\\Broadcasting\\BroadcastController@authenticate',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken',
        ),
        'as' => 'generated::iRyQcTQvnCFvQWaI',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.v1.' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/member/login',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\v1\\JWTAuthController@authenticate',
        'controller' => 'App\\Http\\Controllers\\Api\\v1\\JWTAuthController@authenticate',
        'as' => 'api.v1.',
        'namespace' => 'App\\Http\\Controllers\\Api\\v1',
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.v1.registerJwt' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/member/register',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\v1\\JWTAuthController@register',
        'controller' => 'App\\Http\\Controllers\\Api\\v1\\JWTAuthController@register',
        'as' => 'api.v1.registerJwt',
        'namespace' => 'App\\Http\\Controllers\\Api\\v1',
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.v1.generated::RiIq5pbJAzfZL3oO' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/member/history_by_type',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'jwt.verify',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\v1\\MemberController@historyAll',
        'controller' => 'App\\Http\\Controllers\\Api\\v1\\MemberController@historyAll',
        'as' => 'api.v1.generated::RiIq5pbJAzfZL3oO',
        'namespace' => 'App\\Http\\Controllers\\Api\\v1',
        'prefix' => 'api/v1/member',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.v1.generated::ZPf57ycGSjnmwAPf' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/member',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'jwt.verify',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\v1\\JWTAuthController@getAuthenticatedMember',
        'controller' => 'App\\Http\\Controllers\\Api\\v1\\JWTAuthController@getAuthenticatedMember',
        'as' => 'api.v1.generated::ZPf57ycGSjnmwAPf',
        'namespace' => 'App\\Http\\Controllers\\Api\\v1',
        'prefix' => 'api/v1/member',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.v1.generated::GMDUp0B2jb3HSesb' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/member/balance',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'jwt.verify',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\v1\\JWTAuthController@getBalanceMember',
        'controller' => 'App\\Http\\Controllers\\Api\\v1\\JWTAuthController@getBalanceMember',
        'as' => 'api.v1.generated::GMDUp0B2jb3HSesb',
        'namespace' => 'App\\Http\\Controllers\\Api\\v1',
        'prefix' => 'api/v1/member',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.v1.generated::OYWMDsvzBEzYdKea' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/member/last-bet-win',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'jwt.verify',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\v1\\JWTAuthController@lastBetWin',
        'controller' => 'App\\Http\\Controllers\\Api\\v1\\JWTAuthController@lastBetWin',
        'as' => 'api.v1.generated::OYWMDsvzBEzYdKea',
        'namespace' => 'App\\Http\\Controllers\\Api\\v1',
        'prefix' => 'api/v1/member',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.v1.generated::yFLgzgm43aX44sOv' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/member/last_bet',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'jwt.verify',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\v1\\JWTAuthController@lastBet',
        'controller' => 'App\\Http\\Controllers\\Api\\v1\\JWTAuthController@lastBet',
        'as' => 'api.v1.generated::yFLgzgm43aX44sOv',
        'namespace' => 'App\\Http\\Controllers\\Api\\v1',
        'prefix' => 'api/v1/member',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.v1.generated::xpFSrqC90Gu9YbZO' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/member/last_win',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'jwt.verify',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\v1\\JWTAuthController@lastWin',
        'controller' => 'App\\Http\\Controllers\\Api\\v1\\JWTAuthController@lastWin',
        'as' => 'api.v1.generated::xpFSrqC90Gu9YbZO',
        'namespace' => 'App\\Http\\Controllers\\Api\\v1',
        'prefix' => 'api/v1/member',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.v1.generated::deGXgK7v1zzaNJXD' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/member/history',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'jwt.verify',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\v1\\JWTAuthController@history',
        'controller' => 'App\\Http\\Controllers\\Api\\v1\\JWTAuthController@history',
        'as' => 'api.v1.generated::deGXgK7v1zzaNJXD',
        'namespace' => 'App\\Http\\Controllers\\Api\\v1',
        'prefix' => 'api/v1/member',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.v1.generated::H5tcI2O1fWtjjW31' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/member/refresh',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'jwt.verify',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\v1\\JWTAuthController@refresh',
        'controller' => 'App\\Http\\Controllers\\Api\\v1\\JWTAuthController@refresh',
        'as' => 'api.v1.generated::H5tcI2O1fWtjjW31',
        'namespace' => 'App\\Http\\Controllers\\Api\\v1',
        'prefix' => 'api/v1/member',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.v1.generated::2szyp8fK6KmXAAR8' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/member/logout',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'jwt.verify',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\v1\\JWTAuthController@logout',
        'controller' => 'App\\Http\\Controllers\\Api\\v1\\JWTAuthController@logout',
        'as' => 'api.v1.generated::2szyp8fK6KmXAAR8',
        'namespace' => 'App\\Http\\Controllers\\Api\\v1',
        'prefix' => 'api/v1/member',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.v1.generated::0b99JTePahBy9x93' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/member/change-password',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'jwt.verify',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\v1\\JWTAuthController@changePassword',
        'controller' => 'App\\Http\\Controllers\\Api\\v1\\JWTAuthController@changePassword',
        'as' => 'api.v1.generated::0b99JTePahBy9x93',
        'namespace' => 'App\\Http\\Controllers\\Api\\v1',
        'prefix' => 'api/v1/member',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.v1.generated::bpU6kGesDe4bSnNi' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/member/bonus-referal',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'jwt.verify',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\v1\\MemberController@bonusReferal',
        'controller' => 'App\\Http\\Controllers\\Api\\v1\\MemberController@bonusReferal',
        'as' => 'api.v1.generated::bpU6kGesDe4bSnNi',
        'namespace' => 'App\\Http\\Controllers\\Api\\v1',
        'prefix' => 'api/v1/member',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.v1.generated::6sIYBc7Tidj7iaPL' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/member/deposit/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'jwt.verify',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\v1\\DepositController@create',
        'controller' => 'App\\Http\\Controllers\\Api\\v1\\DepositController@create',
        'as' => 'api.v1.generated::6sIYBc7Tidj7iaPL',
        'namespace' => 'App\\Http\\Controllers\\Api\\v1',
        'prefix' => 'api/v1/member',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.v1.generated::m9JKyMdL1vrmnetA' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/member/bonus/setting-bonus-freebet',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'jwt.verify',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\v1\\DepositController@settingBonusFreebet',
        'controller' => 'App\\Http\\Controllers\\Api\\v1\\DepositController@settingBonusFreebet',
        'as' => 'api.v1.generated::m9JKyMdL1vrmnetA',
        'namespace' => 'App\\Http\\Controllers\\Api\\v1',
        'prefix' => 'api/v1/member/bonus',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.v1.generated::6noqMitwF075CjZg' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/member/bonus/freebet-list',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'jwt.verify',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\v1\\DepositController@freebetBonus',
        'controller' => 'App\\Http\\Controllers\\Api\\v1\\DepositController@freebetBonus',
        'as' => 'api.v1.generated::6noqMitwF075CjZg',
        'namespace' => 'App\\Http\\Controllers\\Api\\v1',
        'prefix' => 'api/v1/member/bonus',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.v1.generated::S0zbolNpsB71YS1J' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/member/bonus/bonus-freebet-giveup',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'jwt.verify',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\v1\\DepositController@BonusFreebetGivUp',
        'controller' => 'App\\Http\\Controllers\\Api\\v1\\DepositController@BonusFreebetGivUp',
        'as' => 'api.v1.generated::S0zbolNpsB71YS1J',
        'namespace' => 'App\\Http\\Controllers\\Api\\v1',
        'prefix' => 'api/v1/member/bonus',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.v1.generated::ebwl0qzCw8UY3Snw' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/member/bonus/setting-bonus-deposit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'jwt.verify',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\v1\\DepositController@settingBonusDeposit',
        'controller' => 'App\\Http\\Controllers\\Api\\v1\\DepositController@settingBonusDeposit',
        'as' => 'api.v1.generated::ebwl0qzCw8UY3Snw',
        'namespace' => 'App\\Http\\Controllers\\Api\\v1',
        'prefix' => 'api/v1/member/bonus',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.v1.generated::ERl5gqDvrwN5Wfue' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/member/bonus/deposit-list',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'jwt.verify',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\v1\\DepositController@depositBonus',
        'controller' => 'App\\Http\\Controllers\\Api\\v1\\DepositController@depositBonus',
        'as' => 'api.v1.generated::ERl5gqDvrwN5Wfue',
        'namespace' => 'App\\Http\\Controllers\\Api\\v1',
        'prefix' => 'api/v1/member/bonus',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.v1.generated::IKSiXwdy7js5rZjY' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/member/bonus/bonus-deposit-giveup',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'jwt.verify',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\v1\\DepositController@BonusDepositGivUp',
        'controller' => 'App\\Http\\Controllers\\Api\\v1\\DepositController@BonusDepositGivUp',
        'as' => 'api.v1.generated::IKSiXwdy7js5rZjY',
        'namespace' => 'App\\Http\\Controllers\\Api\\v1',
        'prefix' => 'api/v1/member/bonus',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.v1.generated::olCbtJP7QI9B9lhu' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/member/withdraw/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'jwt.verify',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\v1\\WithdrawController@create',
        'controller' => 'App\\Http\\Controllers\\Api\\v1\\WithdrawController@create',
        'as' => 'api.v1.generated::olCbtJP7QI9B9lhu',
        'namespace' => 'App\\Http\\Controllers\\Api\\v1',
        'prefix' => 'api/v1/member',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.v1.generated::yV6nMWKNz46RiXSx' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/member/win_lose_status',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'jwt.verify',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\v1\\MemberController@winLoseStatus',
        'controller' => 'App\\Http\\Controllers\\Api\\v1\\MemberController@winLoseStatus',
        'as' => 'api.v1.generated::yV6nMWKNz46RiXSx',
        'namespace' => 'App\\Http\\Controllers\\Api\\v1',
        'prefix' => 'api/v1/member',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.v1.generated::TGCOo52xosu2CpMh' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/member/deposit_withdraw_status',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'jwt.verify',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\v1\\MemberController@depostiWithdrawStatus',
        'controller' => 'App\\Http\\Controllers\\Api\\v1\\MemberController@depostiWithdrawStatus',
        'as' => 'api.v1.generated::TGCOo52xosu2CpMh',
        'namespace' => 'App\\Http\\Controllers\\Api\\v1',
        'prefix' => 'api/v1/member',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.v1.generated::YsYMwFenjv5lZpa9' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/member/memo/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'jwt.verify',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\v1\\MemoController@create',
        'controller' => 'App\\Http\\Controllers\\Api\\v1\\MemoController@create',
        'as' => 'api.v1.generated::YsYMwFenjv5lZpa9',
        'namespace' => 'App\\Http\\Controllers\\Api\\v1',
        'prefix' => 'api/v1/member/memo',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.v1.generated::B3tZXyAKH83CzuDe' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/member/memo/inbox',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'jwt.verify',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\v1\\MemoController@inbox',
        'controller' => 'App\\Http\\Controllers\\Api\\v1\\MemoController@inbox',
        'as' => 'api.v1.generated::B3tZXyAKH83CzuDe',
        'namespace' => 'App\\Http\\Controllers\\Api\\v1',
        'prefix' => 'api/v1/member/memo',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.v1.generated::xHl0LJIL0M2HTDjf' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/member/memo/sent',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'jwt.verify',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\v1\\MemoController@sent',
        'controller' => 'App\\Http\\Controllers\\Api\\v1\\MemoController@sent',
        'as' => 'api.v1.generated::xHl0LJIL0M2HTDjf',
        'namespace' => 'App\\Http\\Controllers\\Api\\v1',
        'prefix' => 'api/v1/member/memo',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.v1.generated::31xeX316spCG82vX' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/member/memo/read',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'jwt.verify',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\v1\\MemoController@read',
        'controller' => 'App\\Http\\Controllers\\Api\\v1\\MemoController@read',
        'as' => 'api.v1.generated::31xeX316spCG82vX',
        'namespace' => 'App\\Http\\Controllers\\Api\\v1',
        'prefix' => 'api/v1/member/memo',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.v1.generated::2uFh94aV82rBexul' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/member/memo/reply',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'jwt.verify',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\v1\\MemoController@reply',
        'controller' => 'App\\Http\\Controllers\\Api\\v1\\MemoController@reply',
        'as' => 'api.v1.generated::2uFh94aV82rBexul',
        'namespace' => 'App\\Http\\Controllers\\Api\\v1',
        'prefix' => 'api/v1/member/memo',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.v1.generated::LHJMu2gfGSYKOEpb' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/member/memo/detail/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'jwt.verify',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\v1\\MemoController@detail',
        'controller' => 'App\\Http\\Controllers\\Api\\v1\\MemoController@detail',
        'as' => 'api.v1.generated::LHJMu2gfGSYKOEpb',
        'namespace' => 'App\\Http\\Controllers\\Api\\v1',
        'prefix' => 'api/v1/member/memo',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.v1.generated::XlYtdiC7oXnTF7zl' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/member/memo/notify-memo',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'jwt.verify',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\v1\\MemoController@NotifyMemo',
        'controller' => 'App\\Http\\Controllers\\Api\\v1\\MemoController@NotifyMemo',
        'as' => 'api.v1.generated::XlYtdiC7oXnTF7zl',
        'namespace' => 'App\\Http\\Controllers\\Api\\v1',
        'prefix' => 'api/v1/member/memo',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.v1.generated::aBpkDCzSt2iFAEBz' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/member/statement',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'jwt.verify',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\v1\\MemberController@getStatement',
        'controller' => 'App\\Http\\Controllers\\Api\\v1\\MemberController@getStatement',
        'as' => 'api.v1.generated::aBpkDCzSt2iFAEBz',
        'namespace' => 'App\\Http\\Controllers\\Api\\v1',
        'prefix' => 'api/v1/member',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.v1.generated::czTtKcEm604hd8Vg' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/member/bonus',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'jwt.verify',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\v1\\MemberController@bonusTurnover',
        'controller' => 'App\\Http\\Controllers\\Api\\v1\\MemberController@bonusTurnover',
        'as' => 'api.v1.generated::czTtKcEm604hd8Vg',
        'namespace' => 'App\\Http\\Controllers\\Api\\v1',
        'prefix' => 'api/v1/member',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.v1.generated::PO7T86cH2HBxgnkH' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/member/statement-depo-wd',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'jwt.verify',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\v1\\MemberController@statementWdDepo',
        'controller' => 'App\\Http\\Controllers\\Api\\v1\\MemberController@statementWdDepo',
        'as' => 'api.v1.generated::PO7T86cH2HBxgnkH',
        'namespace' => 'App\\Http\\Controllers\\Api\\v1',
        'prefix' => 'api/v1/member',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.v1.generated::RNlLdse9OIFTdOv2' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/member/create_rekening_member',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'jwt.verify',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\v1\\MemberController@createRekeningMember',
        'controller' => 'App\\Http\\Controllers\\Api\\v1\\MemberController@createRekeningMember',
        'as' => 'api.v1.generated::RNlLdse9OIFTdOv2',
        'namespace' => 'App\\Http\\Controllers\\Api\\v1',
        'prefix' => 'api/v1/member',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.v1.generated::y4wElsvRaOnVXJeB' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/member/list_rekening_member',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'jwt.verify',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\v1\\MemberController@listRekMember',
        'controller' => 'App\\Http\\Controllers\\Api\\v1\\MemberController@listRekMember',
        'as' => 'api.v1.generated::y4wElsvRaOnVXJeB',
        'namespace' => 'App\\Http\\Controllers\\Api\\v1',
        'prefix' => 'api/v1/member',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.v1.generated::emB02my4eyUrAixp' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/member/list_rek_agent',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'jwt.verify',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\v1\\MemberController@listRekAgent',
        'controller' => 'App\\Http\\Controllers\\Api\\v1\\MemberController@listRekAgent',
        'as' => 'api.v1.generated::emB02my4eyUrAixp',
        'namespace' => 'App\\Http\\Controllers\\Api\\v1',
        'prefix' => 'api/v1/member',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.v1.generated::r8JI872oFlaEFqgO' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/member/rekening_member_wd',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'jwt.verify',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\v1\\MemberController@rekMemberWd',
        'controller' => 'App\\Http\\Controllers\\Api\\v1\\MemberController@rekMemberWd',
        'as' => 'api.v1.generated::r8JI872oFlaEFqgO',
        'namespace' => 'App\\Http\\Controllers\\Api\\v1',
        'prefix' => 'api/v1/member',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.v1.generated::SYkoqscEBoNwH0ed' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/member/update_rekening_member',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'jwt.verify',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\v1\\MemberController@updateRekeningMemberWd',
        'controller' => 'App\\Http\\Controllers\\Api\\v1\\MemberController@updateRekeningMemberWd',
        'as' => 'api.v1.generated::SYkoqscEBoNwH0ed',
        'namespace' => 'App\\Http\\Controllers\\Api\\v1',
        'prefix' => 'api/v1/member',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.v1.generated::msaNjwSI9iKRb5BG' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/member/referral/code',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'jwt.verify',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\v1\\ReferralController@code',
        'controller' => 'App\\Http\\Controllers\\Api\\v1\\ReferralController@code',
        'as' => 'api.v1.generated::msaNjwSI9iKRb5BG',
        'namespace' => 'App\\Http\\Controllers\\Api\\v1',
        'prefix' => 'api/v1/member/referral',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.v1.generated::4fUT1aOjzhMOw0BN' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/member/referral/list',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'jwt.verify',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\v1\\ReferralController@list',
        'controller' => 'App\\Http\\Controllers\\Api\\v1\\ReferralController@list',
        'as' => 'api.v1.generated::4fUT1aOjzhMOw0BN',
        'namespace' => 'App\\Http\\Controllers\\Api\\v1',
        'prefix' => 'api/v1/member/referral',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.v1.generated::lggbtr9yjrRa32Gp' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/cashback',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\v1\\MemberController@cashbackSlot',
        'controller' => 'App\\Http\\Controllers\\Api\\v1\\MemberController@cashbackSlot',
        'as' => 'api.v1.generated::lggbtr9yjrRa32Gp',
        'namespace' => 'App\\Http\\Controllers\\Api\\v1',
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.v1.generated::mjsalB7bh9e1XyLT' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/daily-referal',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\v1\\MemberController@dailyReferal',
        'controller' => 'App\\Http\\Controllers\\Api\\v1\\MemberController@dailyReferal',
        'as' => 'api.v1.generated::mjsalB7bh9e1XyLT',
        'namespace' => 'App\\Http\\Controllers\\Api\\v1',
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.v1.generated::wkKl04imYhRWTE4a' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/bank/destination',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'jwt.verify',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\v1\\BankController@destination',
        'controller' => 'App\\Http\\Controllers\\Api\\v1\\BankController@destination',
        'as' => 'api.v1.generated::wkKl04imYhRWTE4a',
        'namespace' => 'App\\Http\\Controllers\\Api\\v1',
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.v1.generated::lhZlci7teiq5hdng' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/etc/broadcast',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'open.api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\v1\\LanlanController@broadcast',
        'controller' => 'App\\Http\\Controllers\\Api\\v1\\LanlanController@broadcast',
        'as' => 'api.v1.generated::lhZlci7teiq5hdng',
        'namespace' => 'App\\Http\\Controllers\\Api\\v1',
        'prefix' => 'api/v1/etc',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.v1.generated::pxeqU8HWSPVH2xae' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/etc/apk',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'open.api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\v1\\LanlanController@apk',
        'controller' => 'App\\Http\\Controllers\\Api\\v1\\LanlanController@apk',
        'as' => 'api.v1.generated::pxeqU8HWSPVH2xae',
        'namespace' => 'App\\Http\\Controllers\\Api\\v1',
        'prefix' => 'api/v1/etc',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.v1.generated::l73iksTD3PRyhcX2' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/etc/livechat',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'open.api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\v1\\LanlanController@livechat',
        'controller' => 'App\\Http\\Controllers\\Api\\v1\\LanlanController@livechat',
        'as' => 'api.v1.generated::l73iksTD3PRyhcX2',
        'namespace' => 'App\\Http\\Controllers\\Api\\v1',
        'prefix' => 'api/v1/etc',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.v1.generated::pqqFQgAj4tR9Nw5N' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/etc/whatsapp',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'open.api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\v1\\LanlanController@whatsapp',
        'controller' => 'App\\Http\\Controllers\\Api\\v1\\LanlanController@whatsapp',
        'as' => 'api.v1.generated::pqqFQgAj4tR9Nw5N',
        'namespace' => 'App\\Http\\Controllers\\Api\\v1',
        'prefix' => 'api/v1/etc',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.v1.generated::RDtHRsUWipHzOe9m' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/etc/multimedia',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'open.api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\v1\\LanlanController@multimedia',
        'controller' => 'App\\Http\\Controllers\\Api\\v1\\LanlanController@multimedia',
        'as' => 'api.v1.generated::RDtHRsUWipHzOe9m',
        'namespace' => 'App\\Http\\Controllers\\Api\\v1',
        'prefix' => 'api/v1/etc',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.v1.generated::37P3IjMLXDHAbcPU' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/bank',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'open.api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\v1\\BankController@bank',
        'controller' => 'App\\Http\\Controllers\\Api\\v1\\BankController@bank',
        'as' => 'api.v1.generated::37P3IjMLXDHAbcPU',
        'namespace' => 'App\\Http\\Controllers\\Api\\v1',
        'prefix' => 'api/v1/bank',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.v1.generated::k0JXJ5Yzm6olgtw2' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/bank/bank_wd',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'open.api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\v1\\BankController@bankWithdraw',
        'controller' => 'App\\Http\\Controllers\\Api\\v1\\BankController@bankWithdraw',
        'as' => 'api.v1.generated::k0JXJ5Yzm6olgtw2',
        'namespace' => 'App\\Http\\Controllers\\Api\\v1',
        'prefix' => 'api/v1/bank',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.v1.generated::HsNq4up4EkJWZVN5' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/bank/availability',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'open.api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\v1\\BankController@availability',
        'controller' => 'App\\Http\\Controllers\\Api\\v1\\BankController@availability',
        'as' => 'api.v1.generated::HsNq4up4EkJWZVN5',
        'namespace' => 'App\\Http\\Controllers\\Api\\v1',
        'prefix' => 'api/v1/bank',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.v1.generated::TNu1UNm196hESXFs' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/cms/website-content/{slug}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'open.api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\v1\\CmsController@websiteContent',
        'controller' => 'App\\Http\\Controllers\\Api\\v1\\CmsController@websiteContent',
        'as' => 'api.v1.generated::TNu1UNm196hESXFs',
        'namespace' => 'App\\Http\\Controllers\\Api\\v1',
        'prefix' => 'api/v1/cms',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.v1.generated::qEGzpLiWH1kCCQTE' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/cms/image-contents/{type}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'open.api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\v1\\CmsController@imageContent',
        'controller' => 'App\\Http\\Controllers\\Api\\v1\\CmsController@imageContent',
        'as' => 'api.v1.generated::qEGzpLiWH1kCCQTE',
        'namespace' => 'App\\Http\\Controllers\\Api\\v1',
        'prefix' => 'api/v1/cms',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.v1.generated::kpidY0FbuqKSrGKy' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/cms/game-content/{slug}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'open.api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\v1\\CmsController@gameContent',
        'controller' => 'App\\Http\\Controllers\\Api\\v1\\CmsController@gameContent',
        'as' => 'api.v1.generated::kpidY0FbuqKSrGKy',
        'namespace' => 'App\\Http\\Controllers\\Api\\v1',
        'prefix' => 'api/v1/cms',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.v1.generated::bZDkC6eDQPpwc4fY' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/cms/banner_promo_bonus',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'open.api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\v1\\CmsController@bannerPromoBonus',
        'controller' => 'App\\Http\\Controllers\\Api\\v1\\CmsController@bannerPromoBonus',
        'as' => 'api.v1.generated::bZDkC6eDQPpwc4fY',
        'namespace' => 'App\\Http\\Controllers\\Api\\v1',
        'prefix' => 'api/v1/cms',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.v1.generated::PWNjOniTFtPxcn6G' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/contact/message/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'open.api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\v1\\ContactUsController@create',
        'controller' => 'App\\Http\\Controllers\\Api\\v1\\ContactUsController@create',
        'as' => 'api.v1.generated::PWNjOniTFtPxcn6G',
        'namespace' => 'App\\Http\\Controllers\\Api\\v1',
        'prefix' => 'api/v1/contact',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.v1.generated::any8vaw7OWSwMu2L' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/maintenance',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'open.api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\v1\\LanlanController@maintenance',
        'controller' => 'App\\Http\\Controllers\\Api\\v1\\LanlanController@maintenance',
        'as' => 'api.v1.generated::any8vaw7OWSwMu2L',
        'namespace' => 'App\\Http\\Controllers\\Api\\v1',
        'prefix' => 'api/v1/maintenance',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.v1.generated::NSp3ZExEfsxlKAWD' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/maintenance/force-logout',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'open.api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\v1\\JWTAuthController@forceLogout',
        'controller' => 'App\\Http\\Controllers\\Api\\v1\\JWTAuthController@forceLogout',
        'as' => 'api.v1.generated::NSp3ZExEfsxlKAWD',
        'namespace' => 'App\\Http\\Controllers\\Api\\v1',
        'prefix' => 'api/v1/maintenance',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.v1.generated::vN3TSHp2Elr3nEYE' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/maintenance-website',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'open.api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\v1\\LanlanController@maintenanceWebsite',
        'controller' => 'App\\Http\\Controllers\\Api\\v1\\LanlanController@maintenanceWebsite',
        'as' => 'api.v1.generated::vN3TSHp2Elr3nEYE',
        'namespace' => 'App\\Http\\Controllers\\Api\\v1',
        'prefix' => 'api/v1/maintenance-website',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.v1.generated::S8WtoSufX6CwFe6p' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/setting/rolling-value',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'open.api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\v1\\SettingController@rollingValue',
        'controller' => 'App\\Http\\Controllers\\Api\\v1\\SettingController@rollingValue',
        'as' => 'api.v1.generated::S8WtoSufX6CwFe6p',
        'namespace' => 'App\\Http\\Controllers\\Api\\v1',
        'prefix' => 'api/v1/setting',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.v1.generated::J0aC7JDazV4bSd6k' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/setting/limit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'open.api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\v1\\SettingController@limit',
        'controller' => 'App\\Http\\Controllers\\Api\\v1\\SettingController@limit',
        'as' => 'api.v1.generated::J0aC7JDazV4bSd6k',
        'namespace' => 'App\\Http\\Controllers\\Api\\v1',
        'prefix' => 'api/v1/setting',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.v1.generated::HJpH3gFpp1q4dJJp' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/setting/referral_game/{type}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'open.api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\v1\\SettingController@referral_game',
        'controller' => 'App\\Http\\Controllers\\Api\\v1\\SettingController@referral_game',
        'as' => 'api.v1.generated::HJpH3gFpp1q4dJJp',
        'namespace' => 'App\\Http\\Controllers\\Api\\v1',
        'prefix' => 'api/v1/setting',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.v1.generated::mzrbo22ZB9aeGW9N' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/setting/list_togel',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'open.api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\v1\\SettingController@list_togel',
        'controller' => 'App\\Http\\Controllers\\Api\\v1\\SettingController@list_togel',
        'as' => 'api.v1.generated::mzrbo22ZB9aeGW9N',
        'namespace' => 'App\\Http\\Controllers\\Api\\v1',
        'prefix' => 'api/v1/setting',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.v1.generated::uAQFuWNij1grlKze' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/setting/web_page',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'open.api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\v1\\SettingController@web_page',
        'controller' => 'App\\Http\\Controllers\\Api\\v1\\SettingController@web_page',
        'as' => 'api.v1.generated::uAQFuWNij1grlKze',
        'namespace' => 'App\\Http\\Controllers\\Api\\v1',
        'prefix' => 'api/v1/setting',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.v1.generated::Payr9lGPgm84KT3b' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/setting/footer_tag',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'open.api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\v1\\SettingController@footer_tag',
        'controller' => 'App\\Http\\Controllers\\Api\\v1\\SettingController@footer_tag',
        'as' => 'api.v1.generated::Payr9lGPgm84KT3b',
        'namespace' => 'App\\Http\\Controllers\\Api\\v1',
        'prefix' => 'api/v1/setting',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.v1.generated::CZZqogvs2Y4SVsi8' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/setting/whatsapp_url',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'open.api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\v1\\SettingController@whatsappUrl',
        'controller' => 'App\\Http\\Controllers\\Api\\v1\\SettingController@whatsappUrl',
        'as' => 'api.v1.generated::CZZqogvs2Y4SVsi8',
        'namespace' => 'App\\Http\\Controllers\\Api\\v1',
        'prefix' => 'api/v1/setting',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.v1.generated::QN8L9aaTBZY1HUUe' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/setting/social',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'open.api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\v1\\SettingController@social',
        'controller' => 'App\\Http\\Controllers\\Api\\v1\\SettingController@social',
        'as' => 'api.v1.generated::QN8L9aaTBZY1HUUe',
        'namespace' => 'App\\Http\\Controllers\\Api\\v1',
        'prefix' => 'api/v1/setting',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.v1.generated::6btKCWMoSjDiIJ6r' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/setting/seo',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'open.api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\v1\\SettingController@seo',
        'controller' => 'App\\Http\\Controllers\\Api\\v1\\SettingController@seo',
        'as' => 'api.v1.generated::6btKCWMoSjDiIJ6r',
        'namespace' => 'App\\Http\\Controllers\\Api\\v1',
        'prefix' => 'api/v1/setting',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/endpoint/bet',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\ProviderService\\ProviderController@bet',
        'controller' => 'App\\Http\\Controllers\\ProviderService\\ProviderController@bet',
        'as' => 'api.',
        'namespace' => 'App\\Http\\Controllers\\Api',
        'prefix' => 'api/endpoint',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.generated::BGudsoK2jQuGdGHL' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/endpoint/betSpade',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\ProviderService\\ProviderController@betSpade',
        'controller' => 'App\\Http\\Controllers\\ProviderService\\ProviderController@betSpade',
        'as' => 'api.generated::BGudsoK2jQuGdGHL',
        'namespace' => 'App\\Http\\Controllers\\Api',
        'prefix' => 'api/endpoint',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.generated::eBEeKOk6hiaf0mW6' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/endpoint/get_history_pragmatic',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\ProviderService\\ProviderController@gameHistoryPragmatic',
        'controller' => 'App\\Http\\Controllers\\ProviderService\\ProviderController@gameHistoryPragmatic',
        'as' => 'api.generated::eBEeKOk6hiaf0mW6',
        'namespace' => 'App\\Http\\Controllers\\Api',
        'prefix' => 'api/endpoint',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.generated::IMM6JAsQi5SpSdPy' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/endpoint/round',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\ProviderService\\ProviderController@getGameRound',
        'controller' => 'App\\Http\\Controllers\\ProviderService\\ProviderController@getGameRound',
        'as' => 'api.generated::IMM6JAsQi5SpSdPy',
        'namespace' => 'App\\Http\\Controllers\\Api',
        'prefix' => 'api/endpoint',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.generated::G9wx2xEbQvas0Iyn' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/endpoint/bet_pragmatic',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\ProviderService\\ProviderController@betPragmatic',
        'controller' => 'App\\Http\\Controllers\\ProviderService\\ProviderController@betPragmatic',
        'as' => 'api.generated::G9wx2xEbQvas0Iyn',
        'namespace' => 'App\\Http\\Controllers\\Api',
        'prefix' => 'api/endpoint',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.generated::q9lKJqDzP31HAE4n' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/endpoint/result_pragmatic',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\ProviderService\\ProviderController@resultPragmatic',
        'controller' => 'App\\Http\\Controllers\\ProviderService\\ProviderController@resultPragmatic',
        'as' => 'api.generated::q9lKJqDzP31HAE4n',
        'namespace' => 'App\\Http\\Controllers\\Api',
        'prefix' => 'api/endpoint',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.generated::03TQ1crABtJiSlGx' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/endpoint/cancel_bet_pragmatic',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\ProviderService\\ProviderController@cancelBetPragmatic',
        'controller' => 'App\\Http\\Controllers\\ProviderService\\ProviderController@cancelBetPragmatic',
        'as' => 'api.generated::03TQ1crABtJiSlGx',
        'namespace' => 'App\\Http\\Controllers\\Api',
        'prefix' => 'api/endpoint',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.generated::pVSN0mNDfkFM2Igb' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/endpoint/result_habanero',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\ProviderService\\ProviderController@resultHabanero',
        'controller' => 'App\\Http\\Controllers\\ProviderService\\ProviderController@resultHabanero',
        'as' => 'api.generated::pVSN0mNDfkFM2Igb',
        'namespace' => 'App\\Http\\Controllers\\Api',
        'prefix' => 'api/endpoint',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.generated::qSHGdWR0woxJDRc8' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/endpoint/bet_joker',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\ProviderService\\ProviderController@betJoker',
        'controller' => 'App\\Http\\Controllers\\ProviderService\\ProviderController@betJoker',
        'as' => 'api.generated::qSHGdWR0woxJDRc8',
        'namespace' => 'App\\Http\\Controllers\\Api',
        'prefix' => 'api/endpoint',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.generated::Qp8n9Rs46tOYWnNb' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/endpoint/settle_bet_joker',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\ProviderService\\ProviderController@settleBetJoker',
        'controller' => 'App\\Http\\Controllers\\ProviderService\\ProviderController@settleBetJoker',
        'as' => 'api.generated::Qp8n9Rs46tOYWnNb',
        'namespace' => 'App\\Http\\Controllers\\Api',
        'prefix' => 'api/endpoint',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.generated::g1rL8KklD7QL0Nq1' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/endpoint/cancel_bet_joker',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\ProviderService\\ProviderController@cancelBetJoker',
        'controller' => 'App\\Http\\Controllers\\ProviderService\\ProviderController@cancelBetJoker',
        'as' => 'api.generated::g1rL8KklD7QL0Nq1',
        'namespace' => 'App\\Http\\Controllers\\Api',
        'prefix' => 'api/endpoint',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.generated::9PFkw3DJq7Ur1kZW' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/endpoint/balance',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\ProviderService\\ProviderController@balance',
        'controller' => 'App\\Http\\Controllers\\ProviderService\\ProviderController@balance',
        'as' => 'api.generated::9PFkw3DJq7Ur1kZW',
        'namespace' => 'App\\Http\\Controllers\\Api',
        'prefix' => 'api/endpoint',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.generated::rO9Vf8caaFZBVK8o' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/endpoint/result',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\ProviderService\\ProviderController@result',
        'controller' => 'App\\Http\\Controllers\\ProviderService\\ProviderController@result',
        'as' => 'api.generated::rO9Vf8caaFZBVK8o',
        'namespace' => 'App\\Http\\Controllers\\Api',
        'prefix' => 'api/endpoint',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.generated::sHCkCZTco97SwoVg' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/endpoint/transaction_joker',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\ProviderService\\ProviderController@transaction',
        'controller' => 'App\\Http\\Controllers\\ProviderService\\ProviderController@transaction',
        'as' => 'api.generated::sHCkCZTco97SwoVg',
        'namespace' => 'App\\Http\\Controllers\\Api',
        'prefix' => 'api/endpoint',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.generated::X5Zr3Dr9HlUryxRL' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/endpoint/withdraw_joker',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\ProviderService\\ProviderController@withdraw',
        'controller' => 'App\\Http\\Controllers\\ProviderService\\ProviderController@withdraw',
        'as' => 'api.generated::X5Zr3Dr9HlUryxRL',
        'namespace' => 'App\\Http\\Controllers\\Api',
        'prefix' => 'api/endpoint',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.generated::ONSZ6PTFMTBKwKXZ' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/endpoint/deposit_joker',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\ProviderService\\ProviderController@deposit',
        'controller' => 'App\\Http\\Controllers\\ProviderService\\ProviderController@deposit',
        'as' => 'api.generated::ONSZ6PTFMTBKwKXZ',
        'namespace' => 'App\\Http\\Controllers\\Api',
        'prefix' => 'api/endpoint',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.generated::hMGuBhetQxsTXnuf' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/endpoint/resultSpade',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\ProviderService\\ProviderController@resultSpade',
        'controller' => 'App\\Http\\Controllers\\ProviderService\\ProviderController@resultSpade',
        'as' => 'api.generated::hMGuBhetQxsTXnuf',
        'namespace' => 'App\\Http\\Controllers\\Api',
        'prefix' => 'api/endpoint',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.generated::XFhNlqvKC2mTjYMn' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/endpoint/bet_playtech',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\ProviderService\\ProviderController@betPlaytech',
        'controller' => 'App\\Http\\Controllers\\ProviderService\\ProviderController@betPlaytech',
        'as' => 'api.generated::XFhNlqvKC2mTjYMn',
        'namespace' => 'App\\Http\\Controllers\\Api',
        'prefix' => 'api/endpoint',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.generated::KhoYI6EEGmuGzcpa' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/endpoint/cancel_bet_playtech',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\ProviderService\\ProviderController@cancelBetPlaytech',
        'controller' => 'App\\Http\\Controllers\\ProviderService\\ProviderController@cancelBetPlaytech',
        'as' => 'api.generated::KhoYI6EEGmuGzcpa',
        'namespace' => 'App\\Http\\Controllers\\Api',
        'prefix' => 'api/endpoint',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.generated::NOaVE9Zkj6sS0f5l' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/endpoint/result_playtech',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\ProviderService\\ProviderController@resultPlaytech',
        'controller' => 'App\\Http\\Controllers\\ProviderService\\ProviderController@resultPlaytech',
        'as' => 'api.generated::NOaVE9Zkj6sS0f5l',
        'namespace' => 'App\\Http\\Controllers\\Api',
        'prefix' => 'api/endpoint',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.generated::0YSZuBRrEfwg6Nw6' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/endpoint/get_history_spade_gaming',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\ProviderService\\ProviderController@getBetHistorySpadeGaming',
        'controller' => 'App\\Http\\Controllers\\ProviderService\\ProviderController@getBetHistorySpadeGaming',
        'as' => 'api.generated::0YSZuBRrEfwg6Nw6',
        'namespace' => 'App\\Http\\Controllers\\Api',
        'prefix' => 'api/endpoint',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.generated::gAOrpFS7JsREIFZk' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/endpoint/transfer-in-out',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\ProviderService\\ProviderController@PgSoftTransaction',
        'controller' => 'App\\Http\\Controllers\\ProviderService\\ProviderController@PgSoftTransaction',
        'as' => 'api.generated::gAOrpFS7JsREIFZk',
        'namespace' => 'App\\Http\\Controllers\\Api',
        'prefix' => 'api/endpoint',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.generated::9RFiJymo62Ap3D21' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/endpoint/bet_gameHall',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\ProviderService\\GameHallController@listenTransaction',
        'controller' => 'App\\Http\\Controllers\\ProviderService\\GameHallController@listenTransaction',
        'as' => 'api.generated::9RFiJymo62Ap3D21',
        'namespace' => 'App\\Http\\Controllers\\Api',
        'prefix' => 'api/endpoint',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.generated::7qITRqOagqFiPM9k' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/endpoint/result_gameHall',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\ProviderService\\GameHallController@resultGameHall',
        'controller' => 'App\\Http\\Controllers\\ProviderService\\GameHallController@resultGameHall',
        'as' => 'api.generated::7qITRqOagqFiPM9k',
        'namespace' => 'App\\Http\\Controllers\\Api',
        'prefix' => 'api/endpoint',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.generated::p8uhVfWGZ2Y90cAj' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/endpoint/debit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\ProviderService\\QueenmakerController@getDebitQueenMaker',
        'controller' => 'App\\Http\\Controllers\\ProviderService\\QueenmakerController@getDebitQueenMaker',
        'as' => 'api.generated::p8uhVfWGZ2Y90cAj',
        'namespace' => 'App\\Http\\Controllers\\Api',
        'prefix' => 'api/endpoint',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.generated::K7ArA1wL8OJudwpH' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/endpoint/credit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\ProviderService\\QueenmakerController@getCreditQueenMaker',
        'controller' => 'App\\Http\\Controllers\\ProviderService\\QueenmakerController@getCreditQueenMaker',
        'as' => 'api.generated::K7ArA1wL8OJudwpH',
        'namespace' => 'App\\Http\\Controllers\\Api',
        'prefix' => 'api/endpoint',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.generated::GWA1cspiOTTXiuNE' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/endpoint/detail_spade_gaming',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\ProviderService\\ProviderController@detailSpadeGaming',
        'controller' => 'App\\Http\\Controllers\\ProviderService\\ProviderController@detailSpadeGaming',
        'as' => 'api.generated::GWA1cspiOTTXiuNE',
        'namespace' => 'App\\Http\\Controllers\\Api',
        'prefix' => 'api/endpoint',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.generated::b8eOHEGWfIUmzoRg' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/endpoint/settingGames',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\TogelSettingGameController@getTogelSettingGame',
        'controller' => 'App\\Http\\Controllers\\TogelSettingGameController@getTogelSettingGame',
        'as' => 'api.generated::b8eOHEGWfIUmzoRg',
        'namespace' => 'App\\Http\\Controllers\\Api',
        'prefix' => 'api/endpoint',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.generated::QwVbDrWGLBWzsCYH' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/endpoint/provider',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\v2\\OutResult@getResultByProvider',
        'controller' => 'App\\Http\\Controllers\\Api\\v2\\OutResult@getResultByProvider',
        'as' => 'api.generated::QwVbDrWGLBWzsCYH',
        'namespace' => 'App\\Http\\Controllers\\Api',
        'prefix' => 'api/endpoint',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.generated::vz5xJxBPbjumpQQB' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/endpoint/paitoEight',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\v2\\OutResult@paitoEight',
        'controller' => 'App\\Http\\Controllers\\Api\\v2\\OutResult@paitoEight',
        'as' => 'api.generated::vz5xJxBPbjumpQQB',
        'namespace' => 'App\\Http\\Controllers\\Api',
        'prefix' => 'api/endpoint',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.generated::Q9teHbvOJVNJ8HIk' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'POST',
        2 => 'HEAD',
      ),
      'uri' => 'api/endpoint/paitoAll',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\v2\\OutResult@paitoAll',
        'controller' => 'App\\Http\\Controllers\\Api\\v2\\OutResult@paitoAll',
        'as' => 'api.generated::Q9teHbvOJVNJ8HIk',
        'namespace' => 'App\\Http\\Controllers\\Api',
        'prefix' => 'api/endpoint',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.generated::06nZyd2AQKSdOICe' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/endpoint/shio',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\v2\\OutResult@getShioTables',
        'controller' => 'App\\Http\\Controllers\\Api\\v2\\OutResult@getShioTables',
        'as' => 'api.generated::06nZyd2AQKSdOICe',
        'namespace' => 'App\\Http\\Controllers\\Api',
        'prefix' => 'api/endpoint',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.generated::dDmGGweMVxX4pPLE' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/endpoint/list_out_result',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\v2\\OutResult@getAllResult',
        'controller' => 'App\\Http\\Controllers\\Api\\v2\\OutResult@getAllResult',
        'as' => 'api.generated::dDmGGweMVxX4pPLE',
        'namespace' => 'App\\Http\\Controllers\\Api',
        'prefix' => 'api/endpoint',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.generated::Jtchl5Ti09nAyNgv' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/endpoint/pasaran',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\v2\\OutResult@getPasaran',
        'controller' => 'App\\Http\\Controllers\\Api\\v2\\OutResult@getPasaran',
        'as' => 'api.generated::Jtchl5Ti09nAyNgv',
        'namespace' => 'App\\Http\\Controllers\\Api',
        'prefix' => 'api/endpoint',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.generated::JqVbn1x24IFvvxPq' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/endpoint/allPasaran',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\v2\\OutResult@getAllPasaran',
        'controller' => 'App\\Http\\Controllers\\Api\\v2\\OutResult@getAllPasaran',
        'as' => 'api.generated::JqVbn1x24IFvvxPq',
        'namespace' => 'App\\Http\\Controllers\\Api',
        'prefix' => 'api/endpoint',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.generated::gyQsUeJolNG0UWrm' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/endpoint/dreamBooks',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\TogelDreamsBookController@getDreamsBook',
        'controller' => 'App\\Http\\Controllers\\TogelDreamsBookController@getDreamsBook',
        'as' => 'api.generated::gyQsUeJolNG0UWrm',
        'namespace' => 'App\\Http\\Controllers\\Api',
        'prefix' => 'api/endpoint',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.generated::m4s9C0Out8dhBdK6' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/endpoint/globalSetting',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\TogelSettingGameController@getGlobalSettingGame',
        'controller' => 'App\\Http\\Controllers\\TogelSettingGameController@getGlobalSettingGame',
        'as' => 'api.generated::m4s9C0Out8dhBdK6',
        'namespace' => 'App\\Http\\Controllers\\Api',
        'prefix' => 'api/endpoint',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.generated::jkNnv1Uuq88Abl3W' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/endpoint/rules',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\TogelPeraturanGame@getPeraturanGame',
        'controller' => 'App\\Http\\Controllers\\TogelPeraturanGame@getPeraturanGame',
        'as' => 'api.generated::jkNnv1Uuq88Abl3W',
        'namespace' => 'App\\Http\\Controllers\\Api',
        'prefix' => 'api/endpoint',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.generated::aqOvDU4aaZRO5LpB' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/endpoint/getDetailTransaksi',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\v2\\OutResult@getDetailTransaksi',
        'controller' => 'App\\Http\\Controllers\\Api\\v2\\OutResult@getDetailTransaksi',
        'as' => 'api.generated::aqOvDU4aaZRO5LpB',
        'namespace' => 'App\\Http\\Controllers\\Api',
        'prefix' => 'api/endpoint',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.generated::xwjVVTxoVV31Z1Mo' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/endpoint/getDetailTransaksiTogel/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\v1\\MemberController@detailDataTogel',
        'controller' => 'App\\Http\\Controllers\\Api\\v1\\MemberController@detailDataTogel',
        'as' => 'api.generated::xwjVVTxoVV31Z1Mo',
        'namespace' => 'App\\Http\\Controllers\\Api',
        'prefix' => 'api/endpoint',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.generated::Cpu3kve2reFqw6w5' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/endpoint/storeTogel',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'jwt.verify',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\v2\\BetsTogelController@store',
        'controller' => 'App\\Http\\Controllers\\Api\\v2\\BetsTogelController@store',
        'as' => 'api.generated::Cpu3kve2reFqw6w5',
        'namespace' => 'App\\Http\\Controllers\\Api',
        'prefix' => 'api/endpoint',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.generated::v0Kx1WWtf8qOS16p' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/ionx/deduct-player-balance',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\ProviderService\\IONXController@deductPlayerBalance',
        'controller' => 'App\\Http\\Controllers\\ProviderService\\IONXController@deductPlayerBalance',
        'as' => 'api.generated::v0Kx1WWtf8qOS16p',
        'namespace' => 'App\\Http\\Controllers\\Api',
        'prefix' => 'api/ionx',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.generated::ekKUcqn6UnC3dzH7' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/ionx/get-player-balance',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\ProviderService\\IONXController@getPlayerBalance',
        'controller' => 'App\\Http\\Controllers\\ProviderService\\IONXController@getPlayerBalance',
        'as' => 'api.generated::ekKUcqn6UnC3dzH7',
        'namespace' => 'App\\Http\\Controllers\\Api',
        'prefix' => 'api/ionx',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.generated::WE19LedrfPF6hLmE' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/ionx/rollback-player-balance',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\ProviderService\\IONXController@rollbackPlayerBalance',
        'controller' => 'App\\Http\\Controllers\\ProviderService\\IONXController@rollbackPlayerBalance',
        'as' => 'api.generated::WE19LedrfPF6hLmE',
        'namespace' => 'App\\Http\\Controllers\\Api',
        'prefix' => 'api/ionx',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.generated::0rtqCFfQppcQKz7D' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/ionx/Insert-running-bet',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\ProviderService\\IONXController@InsertRunningBet',
        'controller' => 'App\\Http\\Controllers\\ProviderService\\IONXController@InsertRunningBet',
        'as' => 'api.generated::0rtqCFfQppcQKz7D',
        'namespace' => 'App\\Http\\Controllers\\Api',
        'prefix' => 'api/ionx',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.generated::Hx36Yo9zD6mXiRHl' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/ionx/settle-bet',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\ProviderService\\IONXController@SettleBet',
        'controller' => 'App\\Http\\Controllers\\ProviderService\\IONXController@SettleBet',
        'as' => 'api.generated::Hx36Yo9zD6mXiRHl',
        'namespace' => 'App\\Http\\Controllers\\Api',
        'prefix' => 'api/ionx',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.generated::AXFkpUqVlkwgZQk4' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/ionx/insert-game-announcement',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\ProviderService\\IONXController@insertGameAnnouncement',
        'controller' => 'App\\Http\\Controllers\\ProviderService\\IONXController@insertGameAnnouncement',
        'as' => 'api.generated::AXFkpUqVlkwgZQk4',
        'namespace' => 'App\\Http\\Controllers\\Api',
        'prefix' => 'api/ionx',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::YgOA0bzFX45qIv41' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => '/',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:47:"Laravel\\SerializableClosure\\SerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Signed":2:{s:12:"serializable";s:271:"O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:53:"function () {
    return \\json_encode(\'success\');
}";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"0000000000000b190000000000000000";}";s:4:"hash";s:44:"EyVBvk4B6xiLxnKwBsMh4y6nbl6ByRLZxLuKjOtRK3k=";}}',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::YgOA0bzFX45qIv41',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::ogLf1KadxXDULVS6' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'event-balance-test',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:47:"Laravel\\SerializableClosure\\SerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Signed":2:{s:12:"serializable";s:656:"O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:437:"function (\\Illuminate\\Support\\Facades\\Request $request) {
    $user = \\App\\Models\\MembersModel::select(\'id\', \'credit\', \'username\')->find(\\request(\'id\', 1));
    if (\\request(\'event\') == \'betTogel\') {
        \\App\\Events\\BetTogelBalanceEvent::dispatch($user->toArray());
    }
    if (\\request(\'event\') == \'createWithdraw\') {
        \\App\\Events\\WithdrawalCreateBalanceEvent::dispatch($user->toArray());
    }
    return $user;
}";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"0000000000000b8e0000000000000000";}";s:4:"hash";s:44:"QAi1un6YeEO0VLU79tO3qwCPwp4c1Al7vNtNWcoCkqI=";}}',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::ogLf1KadxXDULVS6',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::8UvxpP4PpyMFgoNA' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'event-memo-test',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:47:"Laravel\\SerializableClosure\\SerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Signed":2:{s:12:"serializable";s:569:"O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:350:"function (\\Illuminate\\Support\\Facades\\Request $request) {
    $memo = \\App\\Models\\MemoModel::first();
    if (\\request(\'event\') == \'replay\') {
        \\App\\Events\\NotifyReplyMessageEvent::dispatch($memo);
    }
    if (\\request(\'event\') == \'create\') {
        \\App\\Events\\NotifyNewMemo::dispatch($memo);
    }
    return \'Send Event Memo\';
}";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"0000000000000b900000000000000000";}";s:4:"hash";s:44:"plj5ZuYdfrFwxBCUOT7cbnOLLalQhTjiJHn64hZHzKY=";}}',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::8UvxpP4PpyMFgoNA',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'impersonate' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'impersonate/take/{id}/{guardName?}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Lab404\\Impersonate\\Controllers\\ImpersonateController@take',
        'controller' => '\\Lab404\\Impersonate\\Controllers\\ImpersonateController@take',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'impersonate',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'impersonate.leave' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'impersonate/leave',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Lab404\\Impersonate\\Controllers\\ImpersonateController@leave',
        'controller' => '\\Lab404\\Impersonate\\Controllers\\ImpersonateController@leave',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'impersonate.leave',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
  ),
)
);
