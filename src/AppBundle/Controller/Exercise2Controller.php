<?php

/*
 * Prueba Desarrollador Symfony para Cimacast. Ejercicio 2.
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Controlador para el ejercicio 2.
 * Se construye una tabla de tamaño nxn, que muestra de forma ascendente los números primos comenzando desde el 2.
 */
class Exercise2Controller extends Controller
{
    /**
     * Imprime la vista principal del ejercicio.
     *
     * @param REquest $requestObject El objeto Request de Symfomy
     * @Route("/exercise2", options={ "expose" = false }, name="printTable")
    */
    public function printTable(Request $requestObject)
    {
        $session = $requestObject->getSession();

        if ($requestObject->request->has('submit')) {
            $session->set('n', $requestObject->request->get('number'));
        }

        $n = $session->get('n');
        $args = array();

        if ($n) {
            $primes = $this->primeNumbers(($n*$n));
            $args['n'] = $n;
            $args['primes'] = $primes;
        }

        return $this->render('exercise2/table.html.twig', $args);
    }

    /**
     * Retorna código HTML con la imagen cuyo nombre corresponde al número o un mensaje de error.
     *
     * @param int $number El número primo que corresponde al nombre de la imagen
     * @return Response     Un objeto Response con código HTML
     *
     * @Route("/exercise2/images/{number}", options={ "expose" = true }, name="getNumberImage")
     */
    public function getNumberImage($number)
    {
        $requestObject = Request::createFromGlobals();
        $imagePath = realpath($this->container->getParameter('kernel.root_dir').'/../web');
        $imagePath .= '/images/'.$number.'.jpeg';
        $response = '<p>La imagen correspondiente no existe. &#x1F63F;</p>';

        if (file_exists($imagePath)) {
            $imgBinary = fread(fopen($imagePath, "r"), filesize($imagePath));
            $response = '<img src="data:image/png;base64,'.base64_encode($imgBinary).'" alt="Imagen número primo '.$number.'">';
        }

        return new Response($response);
    }

    /**
     * Retorna los n primeros números primos.
     *
     * @param  int $n           La cantidad de números a retornar
     * @return Array $primes    Arreglo con los números primos
     */
    private function primeNumbers($n)
    {
        $c = 1;
        $p = 2;
        $d = 2;
        $primes = array();

        while ($c <= $n) {
            if (($p % $d) === 0) {
                if ($p === $d) {
                    array_push($primes, $p);
                    $c++;
                }

                $d = 2;
                $p++;
            } else {
                $d++;
            }
        }

        return $primes;
    }
}
