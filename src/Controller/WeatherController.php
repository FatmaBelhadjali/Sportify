<?php

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[Route('/weather')]
class WeatherController extends AbstractController
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    #[Route('/current', name: 'weather_current')]
    public function getCurrentWeather(Request $request): JsonResponse
    {
        $latitude = $request->query->get('lat');
        $longitude = $request->query->get('lon');
        $apiKey = 'c71c7c3ecedc0857e29f675d187c7258'; // Remplacez par votre clé API OpenWeatherMap

        $apiUrl = sprintf(
            'https://api.openweathermap.org/data/2.5/weather?lat=%s&lon=%s&appid=%s',
            $latitude,
            $longitude,
            $apiKey
        );

        $response = $this->client->request('GET', $apiUrl);
        $content = $response->toArray();

        return new JsonResponse($content);
    }
}
