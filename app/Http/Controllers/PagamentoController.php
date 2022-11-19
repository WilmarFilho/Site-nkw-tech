<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class PagamentoController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function checkout() {

        
        if(auth()->user()->assinatura == 'premium') {
            return redirect()->route('home'); //possivel melhoria avisando que o usuario ja tem aasinatura
        }

        else {
            \Stripe\Stripe::setApiKey('sk_test_51LsYCqHCT0bYlJFqcTG8ZP72VfWqIZEgAJlHFUvCMDDf76b2OtYROKo8r2LXBTiGaHYe0o9qGLVNQ5x5Zw3iE8k200OWvffTaE');

            header('Content-Type: application/json');
            

            $YOUR_DOMAIN = 'http://127.0.0.1:8000';

            try {

                $checkout_session = \Stripe\Checkout\Session::create([
                    'line_items' => [[
                        'price' => 'price_1LsefVHCT0bYlJFqwL852CN3',
                        'quantity' => 1,
                    ]],
                    'mode' => 'subscription',
                    'success_url' => $YOUR_DOMAIN . '/sucess?session_id={CHECKOUT_SESSION_ID}',
                    'cancel_url' => $YOUR_DOMAIN . '/',
                ]);
            
                header("HTTP/1.1 303 See Other");
                $link = "<script>location.href='" . $checkout_session->url . "';</script>";
                echo $link;

            } catch (Error $e) {
                http_response_code(500);
                    
                echo json_encode(['error' => $e->getMessage()]);
            
            }
        }


        
    }

    public function pagamentoSucesso() {

        User::where('id', auth()->user()->id)->update(['assinatura' => 'premium']);

        header('Access-Control-Allow-Origin: https://checkout.stripe.com/c/pay/cs_test_a1dEDKpPh7LdfX8M4EFoS1GWVQVatVy2AYKQ0MMHXmsJAIMONp1nkZrNdg#fidkdWxOYHwnPyd1blpxYHZxWjA0SXZcRnRNRlE1Z1xpT0N0aklmfTBOd0hjX1xHN3JrYDRtMWxIZ0dtcWhUaEtiQXZBTWJqZjRENkMxRkEyUTxTZDNzRmhzTVJKMV82dDM0RGdjPXxXMVdVNTVRUVYya05BRicpJ2N3amhWYHdzYHcnP3F3cGApJ2lkfGpwcVF8dWAnPyd2bGtiaWBabHFgaCcpJ2BrZGdpYFVpZGZgbWppYWB3dic%2FcXdwYHgl');

        return redirect()->route('home');

    }

    public function assinar() {

        return view('assinatura');

    }

    

}
