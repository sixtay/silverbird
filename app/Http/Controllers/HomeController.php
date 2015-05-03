<?php namespace App\Http\Controllers;

use GuzzleHttp\Client as GuzzleClient;
use Goutte\Client as Goutte;
use App\Irisii\SilverbirdCrawler;
class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/
	protected $foo;
	const YEAR = '2015';
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		// $this->middleware('auth');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		$crawler = new SilverbirdCrawler();
		// dd($this->getTheMovieDBAPIConfig());
		$goutte_client = new Goutte();

		$crawler = $goutte_client->request('GET', 'http://silverbirdcinemas.com/sec-abuja');

		// dd($crawler->filter('.view-content a'));
		$crawler->filter('#block-system-main .view-content .views-field-title a')->each(function ($node)
		{

			$bar = $this->getMovieInfo($this->getMovieTitle($node), $node);
			// $bar = $node->extract(array('_text'));
			// dd($bar['results'][0]);

			$this->foo[] = $bar;
		});

		// dd($this->foo);
		// die;
		return $this->foo;


		/**
		 * Client for accessing IMDB API
		 * @var GuzzleClient
		 */
	}

	private function getMovieInfo($title, $node)
	{
		// dd($title);
		if ($this->searchTheMovieDBMovieInfo($title)) {
			return $this->searchTheMovieDBMovieInfo($title);
		} elseif ($this->getIMDBMovieInfo($title)) {
			return $this->getIMDBMovieInfo($title);
		} else {
			return 'Couldnt find movie';
		}
	}

	private function getIMDBMovieInfo($title)
	{
		$client = new GuzzleClient();
		$request = $client->createRequest('GET', 'http://www.omdbapi.com/?');
		$query = $request->getQuery();
		$query->set('t', $title);
		$query->set('plot', 'full');
		// dd($query);
		$response = $client->send($request);
		if (count($response->json()) < 4) {
			return false;
		}

		return $response->json();
	}

	private function searchTheMovieDBMovieInfo($title)
	{
		$client = new GuzzleClient();
		$request = $client->createRequest('GET', 'http://api.themoviedb.org/3/search/movie?');
		$query = $request->getQuery();
		$query->set('api_key', '3aa3e49d41a60e7c4519e860e64f8c71');
		$query->set('query', $title);
		$query->set('year', date('Y'));
		$response = $client->send($request);

		if(isset($response->json()['results'][0]['id'])){
			$movieID = $response->json()['results'][0]['id'];
			return $this->getTheMovieDBMovieInfo($movieID);
		}
		// dd($response->json());
		return false;
	}

	private function getTheMovieDBMovieInfo($id)
	{
		$client = new GuzzleClient();
		$request = $client->createRequest('GET', 'http://api.themoviedb.org/3/movie/'.$id);
		$query = $request->getQuery();
		$query->set('api_key', '3aa3e49d41a60e7c4519e860e64f8c71');
		$query->set('append_to_response', 'images,trailers');
		$response = $client->send($request);

		return $response->json();
	}

	private function getTheMovieDBAPIConfig()
	{
		$client = new GuzzleClient();
		$request = $client->createRequest('GET', 'http://api.themoviedb.org/3/configuration');
		$query = $request->getQuery();
		$query->set('api_key', '3aa3e49d41a60e7c4519e860e64f8c71');
		$response = $client->send($request);

		return $response->json();
	}

	private function getSilverbirdMovieInfo()
	{
		
	}

	private function getMovieTitle($node)
	{
		$movieTitle = strpos($node->text(), "(RA") ? trim(substr($node->text(), 0, strpos($node->text(), "(RA"))) : trim($node->text());
		$movieTitle = strpos($movieTitle, "3D") ? trim(substr($movieTitle, 0, strpos($movieTitle, "3D"))) : trim($movieTitle);
		return $movieTitle;
	}

}
