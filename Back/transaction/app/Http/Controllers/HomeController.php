<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransfertController extends Controller
{
    public function index()
    {
        return view('transfert.index');
    }

    public function orangeMoney()
    {
        // Logique pour le service Orange Money
        return response()->json(['message' => 'Service Orange Money']);
    }

    public function orangeMoneyAvecCode()
    {
        // Logique pour le service Orange Money avec code
        return response()->json(['message' => 'Service Orange Money Avec Code']);
    }

    public function orangeMoneySansCode()
    {
        // Logique pour le service Orange Money sans code
        return response()->json(['message' => 'Service Orange Money Sans Code']);
    }

    public function wave()
    {
        // Logique pour le service Wave
        return response()->json(['message' => 'Service Wave']);
    }

    public function wari()
    {
        // Logique pour le service Wari
        return response()->json(['message' => 'Service Wari']);
    }

    public function carteBancaire()
    {
        // Logique pour le service Carte bancaire
        return response()->json(['message' => 'Service Carte Bancaire']);
    }

    public function carteBancairePermanent()
    {
        // Logique pour le service Carte bancaire permanent
        return response()->json(['message' => 'Service Carte Bancaire Permanent']);
    }

    public function carteBancaireImmediat()
    {
        // Logique pour le service Carte bancaire immédiat
        return response()->json(['message' => 'Service Carte Bancaire Immediat']);
    }
}

