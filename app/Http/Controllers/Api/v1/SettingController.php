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
            $geoRegion = "";
            $geoCountry = "";
            $language = "";
            $googlebot = "";
            $robots = "";
            $distribution = "";
            $geoPlacename = "";
            $author = "";
            $publisher = "";
            $ogType = "";
            $ogLocale = "";
            $ogLocaleAlternate = "";
            $itempropName = "";
            $itempropDescription = "";
            $itempropImage = "";
            $ogTitle = "";
            $ogDescription = "";
            $ogSiteName = "";
            $revisitAfter = "";
            $rating = "";
            $twitterTitle = "";
            $twitterDomain = "";
            $twitterCreator = "";
            $twitterDescription = "";
            $linkAmphtml = "";

            if ($metaTag->value) {
                $dom = new \DOMdocument ();
                $metaTagString = str_replace('&', '*HTML_ENTITY*', $metaTag->value);
                $dom->loadhtml($metaTagString);
                if ($dom->getelementsbytagname('meta')) {
                    $datas = [];
                    foreach ($dom->getelementsbytagname('meta') as $meta) {
                        $valueContent = str_replace('*HTML_ENTITY*', '&', $meta->getattribute('content'));
                        if ($meta->getattribute('name') == 'keywords' && $meta->getattribute('content')) {
                            $keyword = $valueContent;
                        }
                        if ($meta->getattribute('name') == 'description' && $meta->getattribute('content')) {
                            $description = $valueContent;
                        }
                        if ($meta->getattribute('name') == 'geo.region' && $meta->getattribute('content')) {
                            $geoRegion = $valueContent;
                        }
                        if ($meta->getattribute('name') == 'geo.country' && $meta->getattribute('content')) {
                            $geoCountry = $valueContent;
                        }
                        if ($meta->getattribute('name') == 'language' && $meta->getattribute('content')) {
                            $language = $valueContent;
                        }
                        if ($meta->getattribute('name') == 'googlebot' && $meta->getattribute('content')) {
                            $googlebot = $valueContent;
                        }
                        if ($meta->getattribute('name') == 'robots' && $meta->getattribute('content')) {
                            $robots = $valueContent;
                        }
                        if ($meta->getattribute('name') == 'distribution' && $meta->getattribute('content')) {
                            $distribution = $valueContent;
                        }
                        if ($meta->getattribute('name') == 'geo.placename' && $meta->getattribute('content')) {
                            $geoPlacename = $valueContent;
                        }
                        if ($meta->getattribute('name') == 'author' && $meta->getattribute('content')) {
                            $author = $valueContent;
                        }
                        if ($meta->getattribute('name') == 'publisher' && $meta->getattribute('content')) {
                            $publisher = $valueContent;
                        }
                        if ($meta->getattribute('property') == 'og:type' && $meta->getattribute('content')) {
                            $ogType = $valueContent;
                        }
                        if ($meta->getattribute('property') == 'og:locale' && $meta->getattribute('content')) {
                            $ogLocale = $valueContent;
                        }
                        if ($meta->getattribute('property') == 'og:locale:alternate' && $meta->getattribute('content')) {
                            $ogLocaleAlternate = $valueContent;
                        }
                        if ($meta->getattribute('name') == 'google-site-verification' && $meta->getattribute('content')) {
                            $googleSiteVerification = $valueContent;
                            $datas[] = $googleSiteVerification;
                        }
                        if ($meta->getattribute('itemprop') == 'name' && $meta->getattribute('content')) {
                            $itempropName = $valueContent;
                        }
                        if ($meta->getattribute('itemprop') == 'description' && $meta->getattribute('content')) {
                            $itempropDescription = $valueContent;
                        }
                        if ($meta->getattribute('itemprop') == 'image' && $meta->getattribute('content')) {
                            $itempropImage = $valueContent;
                        }
                        if ($meta->getattribute('property') == 'og:title' && $meta->getattribute('content')) {
                            $ogTitle = $valueContent;
                        }
                        if ($meta->getattribute('property') == 'og:description' && $meta->getattribute('content')) {
                            $ogDescription = $valueContent;
                        }
                        if ($meta->getattribute('property') == 'og:site_name' && $meta->getattribute('content')) {
                            $ogSiteName = $valueContent;
                        }
                        if ($meta->getattribute('name') == 'revisit-after' && $meta->getattribute('content')) {
                            $revisitAfter = $valueContent;
                        }
                        if ($meta->getattribute('name') == 'rating' && $meta->getattribute('content')) {
                            $rating = $valueContent;
                        }
                        if ($meta->getattribute('name') == 'twitter:creator' && $meta->getattribute('content')) {
                            $twitterCreator = $valueContent;
                        }
                        if ($meta->getattribute('name') == 'twitter:domain' && $meta->getattribute('content')) {
                            $twitterDomain = $valueContent;
                        }
                        if ($meta->getattribute('name') == 'twitter:title' && $meta->getattribute('content')) {
                            $twitterTitle = $valueContent;
                        }
                        if ($meta->getattribute('name') == 'twitter:description' && $meta->getattribute('content')) {
                            $twitterDescription = $valueContent;
                        }
                        if ($meta->getattribute('name') == 'twitter:description' && $meta->getattribute('content')) {
                            $twitterDescription = $valueContent;
                        }
                    }
                }
                if ($dom->getelementsbytagname('link')) {
                    foreach ($dom->getelementsbytagname('link') as $link) {
                        if ($link->getattribute('rel') == 'canonical' && $link->getattribute('href')) {
                            $linkcanonical = $link->getattribute('href');
                        }
                        if ($link->getattribute('rel') == 'amphtml' && $link->getattribute('href')) {
                            $linkAmphtml = $link->getattribute('href');
                        }
                    }
                }
            }
            $googleSiteVerificationArr = [];
            foreach ($datas as $data) {
                $googleSiteVerificationArr[] = ['name' => 'google-site-verification', 'content' => $data];
            }
            $dataMeta = [
                [
                    'name' => "description",
                    'content' => $description,
                ],
                [
                    'name' => "keywords",
                    'content' => $keyword,
                ],
                [
                    'name' => "geo.region",
                    'content' => $geoRegion,
                ],
                [
                    'name' => "geo.country",
                    'content' => $geoCountry,
                ],
                [
                    'name' => "language",
                    'content' => $language,
                ],
                [
                    'name' => "googlebot",
                    'content' => $googlebot,
                ],
                [
                    'name' => "robots",
                    'content' => $robots,
                ],
                [
                    'name' => "distribution",
                    'content' => $distribution,
                ],
                [
                    'name' => "geo.placename",
                    'content' => $geoPlacename,
                ],
                [
                    'name' => "author",
                    'content' => $author,
                ],
                [
                    'name' => "publisher",
                    'content' => $publisher,
                ],
                [
                    'property' => "og:type",
                    'content' => $ogType,
                ],
                [
                    'property' => "og:locale",
                    'content' => $ogLocale,
                ],
//                [
//                    'property' => "og:locale:alternate",
//                    'content' => $ogLocaleAlternate,
//                ],
                [
                    'itemprop' => "name",
                    'content' => $itempropName,
                ],
                [
                    'itemprop' => "description",
                    'content' => $itempropDescription,
                ],
                [
                    'itemprop' => "image",
                    'content' => $itempropImage,
                ],
                [
                    'property' => 'og:title',
                    'content' => $ogTitle
                ],
                [
                    'property' => 'og:site_name',
                    'content' => $ogSiteName
                ],
                [
                    'property' => 'og:description',
                    'content' => $ogDescription
                ],
                [
                    'name' => 'revisit-after',
                    'content' => $revisitAfter
                ],
                [
                    'name' => 'twitter:creator',
                    'content' => $twitterCreator
                ],
                [
                    'name' => 'twitter:domain',
                    'content' => $twitterDomain
                ],
                [
                    'name' => 'twitter:title',
                    'content' => $twitterTitle
                ],
                [
                    'name' => 'twitter:description',
                    'content' => $twitterDescription
                ],
                [
                    'name' => 'rating',
                    'content' => $rating
                ],
            ];
            $meta = array_merge_recursive($dataMeta, $googleSiteVerificationArr);
            if ($title && $metaTag) {
                return response()->json([
                    'status' => 'success',
                    'data' => [
                        'meta' => $meta,
                        'link' => [
                            [
                                'rel' => 'canonical',
                                'href' => $linkcanonical,
                            ],
                            [
                                'rel' => 'amphtml',
                                'href' => $linkAmphtml
                            ]
                        ],
                        'links' => [
                            [
                                'rel' => 'canonical',
                                'href' => $linkcanonical,
                            ],
                            [
                                'rel' => 'amphtml',
                                'href' => $linkAmphtml
                            ]
                        ]
                    ],
                ], 200);
            }

            return $this->successResponse(null, 'Tidak ada konten', 204);
        } catch (\Throwable $th) {
            // return $this->errorResponse($th->getMessage(), 500);
            $meta = [
                [
                    'name' => "description",
                    'content' => '',
                ],
                [
                    'name' => "keywords",
                    'content' => '',
                ],
                [
                    'name' => "geo.region",
                    'content' => '',
                ],
                [
                    'name' => "geo.country",
                    'content' => '',
                ],
                [
                    'name' => "language",
                    'content' => '',
                ],
                [
                    'name' => "googlebot",
                    'content' => '',
                ],
                [
                    'name' => "robots",
                    'content' => '',
                ],
                [
                    'name' => "distribution",
                    'content' => '',
                ],
                [
                    'name' => "geo.placename",
                    'content' => '',
                ],
                [
                    'name' => "author",
                    'content' => '',
                ],
                [
                    'name' => "publisher",
                    'content' => '',
                ],
                [
                    'property' => "og:type",
                    'content' => '',
                ],
                [
                    'property' => "og:locale",
                    'content' => '',
                ],
                [
                    'itemprop' => "name",
                    'content' => '',
                ],
                [
                    'itemprop' => "description",
                    'content' => '',
                ],
                [
                    'itemprop' => "image",
                    'content' => '',
                ],
            ];
            return response()->json([
                'status' => 'error',
                'message' => 'meta tag tidak cocok, silakan periksa kode meta tag Anda',
                'data' => [
                    'meta' => $meta,
                    'link' => [
                        'rel' => 'canonical',
                        'href' => '',
                    ],
                    'links' => []
                ],
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
            $list_togel = ConstantProviderTogelModel::select('id', 'name', 'name_initial', 'website_url')->where('status', 1)->orWhere('auto_online', 1)->get();

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
    public function footer_tag()
    {
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
                ['type', 'web_page'],
            ])->get();
            // $whatsappNumber = AppSetting::select('name', 'value')->where([
            //     ['name', 'whatsapp'],
            //     ['type', 'social_media'],
            // ])->get();
            if ($whatsappUrl) {
                // return $this->successResponse($whatsappUrl->toArray(), 'Whatsapp URL is exist', 200);
                return response()->json([
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'Nomor dan URL ditemukan',
                    'data' => [
                        'text' => $whatsappUrl->toArray(),
                        // 'number' => $whatsappNumber->toArray()
                    ],
                ]);
            }

            return $this->successResponse(null, 'Tidak ada konten', 204);
        } catch (\Throwable $th) {
            return $this->errorResponse('Internal Server Error', 500);
        }
    }
}
