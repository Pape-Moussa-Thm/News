<?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use App\Models\Client;
// use App\Models\Compte;
// use App\Models\Transaction;
// use App\Http\Resources\TransactionResource;

// class TransactionController extends Controller
// {
//     // Afficher les transactions effectuées via Orange Money
//     public function getOrangeMoneyTransactions()
//     {
//         $transactions = Transaction::where('type', 'Orange Money')->get();
//         return TransactionResource::collection($transactions);
//     }
//     public function makeOrangeMoneyTransferWithCode(Request $request)
//     {
//         $validatedData = $request->validate([
//             'client_telephone' => 'required|string|exists:clients,telephone',
//             'montant' => 'required|numeric|max:1000000', // On ne peut envoyer plus de 1.000.000 pour Orange Money
//         ]);

//         // Logique pour effectuer le transfert avec code
//         $client = Client::where('telephone', $validatedData['client_telephone'])->first();

//         // Vérifier si le client a suffisamment de solde pour effectuer le transfert
//         $solde = $client->compte->solde;
//         if ($solde < $validatedData['montant']) {
//             return response()->json(['message' => 'Solde insuffisant pour effectuer le transfert'], 400);
//         }

//         // Effectuer le transfert
//         $frais = $validatedData['montant'] * 0.01; // Frais de 1% pour Orange Money
//         $montantTransfert = $validatedData['montant'] - $frais;

//         $transaction = new Transaction();
//         $transaction->compte_id = $client->compte->id;
//         $transaction->type = 'Orange Money';
//         $transaction->montant = -$montantTransfert; // Montant négatif pour le transfert sortant
//         $transaction->save();

//         // Mettre à jour le solde du compte du client
//         $client->compte->solde -= $validatedData['montant'];
//         $client->compte->save();

//         return response()->json(['message' => 'Transfert Orange Money avec code effectué']);
//     }

//     // Afficher les transactions effectuées via Wave
//     public function getWaveTransactions()
//     {
//         $transactions = Transaction::where('type', 'Wave')->get();
//         return TransactionResource::collection($transactions);
//     }

//     // Afficher les transactions effectuées via Wari
//     public function getWariTransactions()
//     {
//         $transactions = Transaction::where('type', 'Wari')->get();
//         return TransactionResource::collection($transactions);
//     }

//     // Faire un transfert permanent via CB
//     public function makePermanentCBTransfer(Request $request)
//     {
//         $validatedData = $request->validate([
//             'sender_compte_numero' => 'required|string',
//             'receiver_compte_numero' => 'required|string',
//             'montant' => 'required|numeric',
//         ]);

//         // Logique pour effectuer le transfert permanent via CB
//         $senderCompte = Compte::where('numero_compte', $validatedData['sender_compte_numero'])->first();
//         $receiverCompte = Compte::where('numero_compte', $validatedData['receiver_compte_numero'])->first();

//         // Vérifier si les comptes existent
//         if (!$senderCompte || !$receiverCompte) {
//             return response()->json(['message' => 'Compte expéditeur ou compte bénéficiaire introuvable'], 404);
//         }

//         // Vérifier si le transfert est autorisé entre ces types de compte (CB vers CB)
//         if ($senderCompte->fournisseur !== 'CB' || $receiverCompte->fournisseur !== 'CB') {
//             return response()->json(['message' => 'Les transferts ne sont autorisés qu\'entre compte CB'],400);
//         }

//         // Vérifier si le client a suffisamment de solde pour effectuer le transfert
//         $solde = $senderCompte->solde;
//         if ($solde < $validatedData['montant']) {
//             return response()->json(['message' => 'Solde insuffisant pour effectuer le transfert'], 400);
//         }

//         // Effectuer le transfert
//         $frais = $validatedData['montant'] * 0.05; // Frais de 5% pour CB
//         $montantTransfert = $validatedData['montant'] - $frais;

//         $transaction = new Transaction();
//         $transaction->compte_id = $senderCompte->id;
//         $transaction->type = 'CB';
//         $transaction->montant = -$montantTransfert; // Montant négatif pour le transfert sortant
//         $transaction->save();

//         // Mettre à jour le solde du compte expéditeur et du compte bénéficiaire
//         $senderCompte->solde -= $validatedData['montant'];
//         $receiverCompte->solde += $montantTransfert;
//         $senderCompte->save();
//         $receiverCompte->save();

//         return response()->json(['message' => 'Transfert permanent CB effectué']);
//     }

//     // Faire un transfert immédiat via CB
//     public function makeImmediateCBTransfer(Request $request)
//     {
//         $validatedData = $request->validate([
//             'sender_compte_numero' => 'required|string',
//             'receiver_compte_numero' => 'required|string',
//             'montant' => 'required|numeric',
//         ]);

//         // Logique pour effectuer le transfert immédiat via CB

//         return response()->json(['message' => 'Transfert immédiat CB effectué']);
//     }
// }


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Compte;
use App\Models\Transaction;

class TransactionController extends Controller
{
    // Méthode pour effectuer un dépôt
    public function makeDeposit(Request $request)
    {
        // Règles de validation
        $rules = [
            'montant' => 'required|numeric|min:0', // Montant doit être un nombre positif
            'telephone_client' => 'required|exists:clients,telephone', // Vérifier si le numéro de téléphone du client existe dans la table "clients"
        ];

        $messages = [
            'telephone_client.exists' => "Le numéro de téléphone du client n'existe pas.",
        ];

        $this->validate($request, $rules, $messages);

        // Recherchez le compte associé au numéro de téléphone du client
        $client = Client::where('telephone', $request->input('telephone_client'))->first();
        $compte = $client->compte;

        // Effectuer le dépôt
        $montant = $request->input('montant');
        $compte->solde += $montant;
        $compte->save();

        // Créez une transaction pour le dépôt
        Transaction::create([
            'compte_id' => $compte->id,
            'type' => 'Dépôt',
            'montant' => $montant,
        ]);

        return response()->json(['message' => 'Dépôt effectué avec succès.'], 200);
    }

    // Méthode pour effectuer un retrait avec code
    public function makeWithdrawalWithCode(Request $request)
    {
        // Règles de validation
        $rules = [
            'montant' => 'required|numeric|min:0',
        ];

        $this->validate($request, $rules);

        // Générez un code de 25 chiffres pour le retrait
        $code = mt_rand(1000000000000000000000000, 9999999999999999999999999);

        // Enregistrez le code et le montant dans la base de données
        Transaction::create([
            'type' => 'Retrait avec code',
            'montant' => $request->input('montant'),
            'code' => $code,
        ]);

        return response()->json(['code' => $code], 200);
    }

    // Méthode pour effectuer un transfert compte à compte
    public function makeTransfer(Request $request)
    {
        // Règles de validation
        $rules = [
            'montant' => 'required|numeric|min:0',
            'numero_compte_source' => 'required|exists:comptes,numero_compte', // Vérifier si le numéro de compte source existe dans la table "comptes"
            'numero_compte_dest' => 'required|exists:comptes,numero_compte', // Vérifier si le numéro de compte destination existe dans la table "comptes"
        ];

        $messages = [
            'numero_compte_source.exists' => "Le numéro de compte source n'existe pas.",
            'numero_compte_dest.exists' => "Le numéro de compte destination n'existe pas.",
        ];

        $this->validate($request, $rules, $messages);

        // Recherchez les comptes source et destination
        $compteSource = Compte::where('numero_compte', $request->input('numero_compte_source'))->first();
        $compteDest = Compte::where('numero_compte', $request->input('numero_compte_dest'))->first();

        // Vérifiez si les comptes sont du même fournisseur
        $fournisseurSource = substr($compteSource->numero_compte, 0, 2);
        $fournisseurDest = substr($compteDest->numero_compte, 0, 2);

        if ($fournisseurSource !== $fournisseurDest) {
            return response()->json(['message' => "Les transferts ne sont autorisés qu'entre comptes du même fournisseur."], 400);
        }

        // Vérifiez si le montant du transfert ne dépasse pas la limite pour le fournisseur
        $frais = 0;
        if ($fournisseurSource === 'CB') {
            // Pour les comptes CB, le montant peut dépasser 1 000 000
            $limite = 0;
        } else {
            // Pour les autres fournisseurs
            $limite = 1000000;
            $frais = $montant * 0.01; // Frais de 1%
        }

        $montant = $request->input('montant');
        if ($montant > $compteSource->solde) {
            return response()->json(['message' => "Solde insuffisant pour effectuer le transfert."], 400);
        }

        if ($montant > $limite) {
            return response()->json(['message' => "Le montant du transfert dépasse la limite autorisée."], 400);
        }

        // Effectuez le transfert
        $compteSource->solde -= $montant;
        $compteDest->solde += $montant - $frais;
        $compteSource->save();
        $compteDest->save();

        // Créez une transaction pour le transfert
        Transaction::create([
            'compte_id' => $compteSource->id,
            'type' => 'Transfert compte à compte',
            'montant' => $montant,
        ]);

        return response()->json(['message' => 'Transfert effectué avec succès.'], 200);
    }

    // Méthode pour effectuer un dépôt chez Wari
public function makeDepositWari(Request $request)
{
    // Règles de validation
    $rules = [
        'montant' => 'required|numeric|min:0',
        'telephone_dest' => 'required|exists:clients,telephone', // Vérifier si le numéro de téléphone du destinataire existe dans la table "clients"
    ];

    $messages = [
        'telephone_dest.exists' => "Le numéro de téléphone du destinataire n'existe pas.",
    ];

    $this->validate($request, $rules, $messages);

    // Générez un code de 15 chiffres pour le dépôt chez Wari
    $codeWari = mt_rand(100000000000000, 999999999999999);

    // Enregistrez le code et le montant dans la base de données
    Transaction::create([
        'type' => 'Dépôt chez Wari',
        'montant' => $request->input('montant'),
        'code' => $codeWari,
    ]);

    return response()->json(['code_wari' => $codeWari], 200);
}

// Méthode privée pour calculer les frais
private function calculerFrais($type, $montant)
{
    switch ($type) {
        case 'Orange Money':
        case 'Wave':
            return $montant * 0.01; // Frais de 1%
        case 'Wari':
            return $montant * 0.02; // Frais de 2%
        case 'CB':
            return $montant * 0.05; // Frais de 5%
        default:
            return 0; // Aucun frais pour les autres types de transfert
    }
}


    // Autres méthodes pour les autres types de transferts, comme les transferts Wari, les transferts CB, etc.

}

