<?php

namespace App\Http\Controllers;

class LandingPageController extends Controller
{
    public function index()
    {
        return view('landing.index', [
            'title' => 'Basix One — CRM + ERP White Label',
            'meta'  => [
                'description' => 'Venda CRM + ERP white label em um só lugar. Multi-tenant, rápido e flexível.',
                'og_image'    => asset('images/og-basix-one.jpg'),
            ],
        ]);
    }
}
