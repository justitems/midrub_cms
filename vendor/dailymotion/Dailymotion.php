<?php
/**
 * Dailymotion
 *
 * PHP Version 5.6
 *
 * Connect and Publish to Dailymotion
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
if (! defined ( 'BASEPATH' )) {
	exit ( 'No direct script access allowed' );
}
/**
 * Dailymotion class - allows users to connect to their Dailymotion Account and upload videos
 *
 * @category Social
 * @package Midrub
 * @author Scrisoft <asksyn@gmail.com>
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link https://www.midrub.com/
 */
class Dailymotion implements Autopost {
	protected $api, $callback, $CI, $clientId, $clientSecret;
	/**
	 * Load networks and user model.
	 */
	public function __construct() {
		$this->CI = & get_instance ();
		// Load Networks Model
		$this->CI->load->model ( 'networks' );
		// Load User Model
		$this->CI->load->model ( 'user' );
		$this->clientId = get_option ( 'dailymotion_client_id' );
		$this->clientSecret = get_option ( 'dailymotion_client_secret' );
		$this->callback = get_instance ()->config->base_url () . 'user/callback/dailymotion';
		include_once FCPATH . 'vendor/dailymotion/Dailymotion.php';
		$this->api = new Dailymotion2();
	}
	/**
	 * First function check if the Dailymotion api is configured correctly.
	 *
	 * @return will be true if the client_id, apiKey, and client_secret is not empty
	 */
	public function check_availability() {
		if (($this->clientId != '') and ($this->clientSecret != '')) {
			return true;
		} else {
			return false;
		}
	}
	/**
	 * This function will redirect user to Google login page.
	 */
	public function connect() {
		$authUrl = 'https://www.dailymotion.com/oauth/authorize?response_type=code&client_id='.$this->clientId.'&scope=manage_videos&redirect_uri='.$this->callback;
		header ( 'Location:' . $authUrl );
	}
	/**
	 * This function will get access token.
	 *
	 * @param $token contains
	 *        	the token for some social networks
	 */
	public function save($token = null) {
		if (isset ( $_GET ['code'] )) {
			$curl = curl_init("https://api.dailymotion.com/oauth/token");
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt(
					$curl, CURLOPT_POSTFIELDS, [
							'client_id' => $this->clientId,
							'client_secret' => $this->clientSecret,
							'code' => $_GET['code'],
							'redirect_uri' => $this->callback,
							'grant_type' => 'authorization_code'
					]
					);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			$data = curl_exec($curl);
			curl_close($curl);
			$data = json_decode($data);
			$video = FCPATH . 'vendor/dailymotion/likes.avi';
			$getUploadUrl = "curl -d 'access_token=$data->access_token'  -F 'file=@$video'  https://api.dailymotion.com/file/upload/";
			$uploadUrl = json_decode(system($getUploadUrl));
			var_dump($uploadUrl);
			exit();
		}
	}
	/**
	 * This function publishes posts on Dailymotion.
	 *
	 * @param $args contains
	 *        	the post data.
	 * @param $user_id is
	 *        	the ID of the current user
	 * @return true if post was published
	 */
	public function post($args, $user_id = null) {
		if ($user_id) {
			// if the $user_id variable is not null, will be published a postponed post
			$con = $this->CI->networks->get_network_data ( strtolower ( 'Dailymotion' ), $user_id, $args ['account'] );
		} else {
			$con = $this->CI->networks->get_network_data ( strtolower ( 'Dailymotion' ), $this->CI->user->get_user_id_by_username ( $this->CI->session->userdata ['username'] ), $args ['account'] );
		}
		if ($con) {
			if ($con [0]->secret) {
				try {
					$video = str_replace(base_url(),FCPATH,$args['video']);
					$this->client->refreshToken($con[0]->secret);
					$newtoken = $this->client->getAccessToken();
					$this->client->setAccessToken($newtoken);
					$file_info = finfo_open(FILEINFO_MIME_TYPE);
					$mime_type = finfo_file($file_info, $video);
					$video_snippet = new Google_VideoSnippet();
					$body = explode ( '.', $args ['post'] );
					if (@$body [1]) {
						$video_snippet->setTitle($body[0]);
						$video_snippet->setDescription(str_replace($body[0].'.','',$args['post']));
					} else {
						$video_snippet->setTitle($args['post']);
					}
					$status = new Google_VideoStatus();
					$status->setPrivacyStatus('public');
					$google_video = new Google_Video();
					$google_video->setSnippet($video_snippet);
					$google_video->setStatus($status);
					$upload = $this->Dailymotion->videos->insert('snippet,status', $google_video, array(
							'data' => file_get_contents($video),
							'mimeType' => $mime_type,
					));
					if($upload)
					{
						return true;
					}
					else{
						return false;
					}
				} catch ( Exception $e ) {
					return false;
				}
			}
		}
	}
	/**
	 * This function displays information about this class.
	 */
	public function get_info() {
		return ( object ) [ 
				'color' => '#ca3737',
				'icon' => '<i class="fa fa-video-camera" aria-hidden="true"></i>',
				'rss' => true,
				'api' => [ 
						'client_id',
						'client_secret',
				],
				'types' => 'text, links',
				'categories' => false
		];
	}
	/**
	 * This function generates a preview for Dailymotion.
	 *
	 * @param $args contains
	 *        	the video or url.
	 */
	public function preview($args) {
		if(filter_var($args["video"], FILTER_VALIDATE_URL))
		{
			$video = '<div>
                        <p class="previmg"><iframe frameborder="0" src="'.$args["video"].'" style="width:100%;height:300px"></iframe></p>
                        <p class="prevtext"></p>
                    </div>';
		}
		else{
			return (object) ['info' => '<div class="col-lg-12 merror"><p><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Please, enter upload a video in the field above.</p></div>'];
		}
		return ( object ) [ 
				'name' => 'Dailymotion',
				'icon' => '<button type="button" class="btn btn-network-y"><i class="fa fa-video-camera" aria-hidden="true"></i><span data-network="dailymotion"><i class="fa fa-times"></i></span></button>',
				'head' => '<li class="Dailymotion"><a href="#Dailymotion" data-toggle="tab"><i class="fa fa-video-camera" aria-hidden="true"></i></li>',
				'content' => '<div class="tab-pane" id="Dailymotion">
					                  <div class="Dailymotion forall">
									      ' . $video . '
									  </div>
								  </div>' 
		];
	}
}
