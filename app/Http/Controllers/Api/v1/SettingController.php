<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\ApiController;
use App\Models\AppSetting;
use App\Models\ConstantProviderTogelModel;

class SettingController extends ApiController
{
    public function rollingValue()
    {
        try {
            $rolling = AppSetting::select('name', 'value')->where('type', 'bonus')->get();
            if ($rolling) {
                return $this->successResponse($rolling->toArray());
            }

            return $this->successResponse(null, 'Tidak ada konten', 204);
        } catch (\Throwable $th) {
            return $this->errorResponse('Internal Server Error', 500);
        }
    }
    public function limit()
    {
        try {
            $limit = AppSetting::select('name', 'value')->where('type', 'web')->get();
            if ($limit) {
                return $this->successResponse($limit->toArray());
            }

            return $this->successResponse(null, 'Tidak ada konten', 204);
        } catch (\Throwable $th) {
            return $this->errorResponse('Internal Server Error', 500);
        }
    }
    public function seo()
    {
        try {
            $title = AppSetting::select('name', 'value')->where('name', 'title')->first();
            $metaTag = AppSetting::select('name', 'value')->where('name', 'meta_tag')->first();
            $linkcanonical = "";
            $keyword = "";
            $description = "";
            $googleSiteVerification = "";
            $itempropName = "";
            $itempropDescription = "";
            $itempropImage = "";
            if($metaTag->value){
                $dom = new \DOMdocument();
                $dom->loadhtml($metaTag->value);       
                if ($dom->getelementsbytagname('meta')) {
                    $datas = [];
                    foreach($dom->getelementsbytagname('meta') as $meta) {
                        if($meta->getattribute('name') == 'keywords' && $meta->getattribute('content')) {
                            $keyword = $meta->getattribute('content');
                        }
                        if($meta->getattribute('name') == 'description' && $meta->getattribute('content')) {
                            $description = $meta->getattribute('content');
                        }
                        if($meta->getattribute('name') == 'google-site-verification' && $meta->getattribute('content')) {
                            $googleSiteVerification = $meta->getattribute('content');
                            $datas[] = $googleSiteVerification;                            
                        }
                        if($meta->getattribute('itemprop') == 'name' && $meta->getattribute('content')) {
                            $itempropName = $meta->getattribute('content');
                        }
                        if($meta->getattribute('itemprop') == 'description' && $meta->getattribute('content')) {
                            $itempropDescription = $meta->getattribute('content');
                        }
                        if($meta->getattribute('itemprop') == 'image' && $meta->getattribute('content')) {
                            $itempropImage = $meta->getattribute('content');
                        }
                    }
                }              
                if ($dom->getelementsbytagname('link')) {               
                    foreach($dom->getelementsbytagname('link') as $link) {
                        if($link->getattribute('rel') == 'canonical' && $link->getattribute('href')) {
                            $linkcanonical = $link->getattribute('href');
                        }
                    }
                }        
            }
            $googleSiteVerificationArr = [];
            foreach ($datas as $data){
                $googleSiteVerificationArr[] = ['name' => 'google-site-verification', 'content' => $data];
            }
            if ($title && $metaTag) {
                return response()->json([
                    'status' => 'success',
                    'data' => [
                        'meta' => [
                            [
                                'name' => "description",
                                'content' => $description
                            ],
                            [
                                'name' => "keywords",
                                'content' => $keyword
                            ],                        
                            [
                                'itemprop' => "name",
                                'content' => $itempropName
                            ],                            
                            [
                                'itemprop' => "description",
                                'content' => $itempropDescription
                            ],                            
                            [
                                'itemprop' => "image",
                                'content' => $itempropImage
                            ],
                        ],
                        'googleSiteVerification' => $googleSiteVerificationArr,    
                        'link' => [
                            'rel'  => 'canonical',
                            'href' => $linkcanonical,
                        ]
                    ]
                ], 200);                
            }

            return $this->successResponse(null, 'Tidak ada konten', 204);
        } catch (\Throwable $th) {            
            // return $this->errorResponse($th->getMessage(), 500);
            return response()->json([
                'status' => 'error',
                'message' => 'meta tag tidak cocok, silakan periksa kode meta tag Anda',
                'data' => [
                    'meta' => [
                        [
                            'name' => "description",
                            'content' => $description
                        ],
                        [
                            'name' => "keywords",
                            'content' => $keyword
                        ],                        
                        [
                            'itemprop' => "name",
                            'content' => $itempropName
                        ],                            
                        [
                            'itemprop' => "description",
                            'content' => $itempropDescription
                        ],                            
                        [
                            'itemprop' => "image",
                            'content' => $itempropImage
                        ],
                    ],
                    'googleSiteVerification' => [],    
                    'link' => [
                        'rel'  => 'canonical',
                        'href' => $linkcanonical,
                    ]
                ]
            ], 400);
        }
    }

    public function referral_game($type)
    {
        try {
            $referral_game = AppSetting::select('name', 'value')->where('type', 'game')->get();
          
            if ($referral_game && $type == 'slot') {
                return $this->successResponse($referral_game->toArray());
            }

            if ($referral_game && $type == 'fish') {
                $fakeArray = [];
                $fakeArray[] = [
                    'name' => 'fishing_king',
                    'value' => '0.1',
                ];
                $fakeArray[] = [
                    'name' => 'fishing_fortune',
                    'value' => '0.1',
                ];
                $fakeArray[] = [
                    'name' => 'egypth_fa_fa',
                    'value' => '0.1',
                ];
                $fakeArray[] = [
                    'name' => 'fa_chai_fishing',
                    'value' => '0.1',
                ];
                 $fakeArray[] = [
                    'name' => 'monster_fishing',
                    'value' => '0.1',
                ];
                $fakeArray[] = [
                    'name' => 'fishing_god',
                    'value' => '0.1',
                ];
                $fakeArray[] = [
                    'name' => 'fishing_war',
                    'value' => '0.1',
                ];

                return $this->successResponse($fakeArray);
            }

            return $this->successResponse(null, 'Tidak ada konten', 204);
        } catch (\Throwable $th) {
            return $this->errorResponse('Internal Server Error', 500);
        }
    }

    // list togel
    public function list_togel()
    {
        try {
            $list_togel = ConstantProviderTogelModel::select('id','name', 'name_initial','website_url')->where('status', 1)->orWhere('auto_online', 1)->get();

            if ($list_togel) {
                return $this->successResponse($list_togel->toArray(), 'Daftar Togel Ditemukan');
            }

            return $this->successResponse(null, 'Tidak ada daftar Togel', 204);
        } catch (\Throwable $th) {
            return $this->errorResponse('Internal Server Error', 500);
        }
    }

    public function web_page()
    {
        try {
            $web_page = AppSetting::select('name', 'value')->where('type', 'web_page')->get();
            if ($web_page) {
                return $this->successResponse($web_page->toArray());
            }

            return $this->successResponse(null, 'Tidak ada konten', 204);
        } catch (\Throwable $th) {
            return $this->errorResponse('Internal Server Error', 500);
        }
    }

    // get footer tag
    public function footer_tag(){
        try {
            $footer_tag = AppSetting::select('name', 'value')->where('name', 'footer_tag')->first();
            if ($footer_tag) {
                return $this->successResponse($footer_tag->toArray());
            }
            return $this->successResponse(null, 'Tidak ada konten', 204);
        } catch (\Throwable $th) {
            return $this->errorResponse('Internal Server Error', 500);
        }
    }

    // get social mendia
    public function social()
    {
        try {
            $social = AppSetting::select('name', 'value')->where('type', 'social_media')->get();
            if ($social) {
                return $this->successResponse($social->toArray());
            }

            return $this->successResponse(null, 'Tidak ada konten', 204);
        } catch (\Throwable $th) {
            return $this->errorResponse('Internal Server Error', 500);
        }
    }

    // get whatsapp url
    public function whatsappUrl()
    {
        try {
            $whatsappUrl = AppSetting::select('name', 'value')->where([
                ['name', 'whats_app_url'],
                ['type', 'web_page']
                ])->get();
            $whatsappNumber = AppSetting::select('name', 'value')->where([
                ['name', 'whatsapp'],
                ['type', 'social_media']
                ])->get();
            if ($whatsappUrl && $whatsappNumber) {
                // return $this->successResponse($whatsappUrl->toArray(), 'Whatsapp URL is exist', 200);
                return response()->json([
                    'status' => 'success',
                    'code'  => 200,
                    'message' => 'Nomor dan URL ditemukan',
                    'data'  => [
                        'text' => $whatsappUrl->toArray(),
                        'number' => $whatsappNumber->toArray()
                    ]
                ]);
            }

            return $this->successResponse(null, 'Tidak ada konten', 204);
        } catch (\Throwable $th) {
            return $this->errorResponse('Internal Server Error', 500);
        }
    }
}