<?php


namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;


class BaseController extends Controller
{
    private $result;

    public bool $isGuest;

    public function __construct(Request $request)
    {
        $this->isGuest = $request->user() === null;
    }

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result = [], $message = 'success',$paginate = FALSE)
    {
        $this->result = $result;
        if($paginate == TRUE){
            $this->paginate($result);
        }

    	$response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];


        return response()->json($response, 200);
    }


    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 400)
    {
    	$response = [
            'success' => false,
            'message' => $error,
        ];


        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }


        return response()->json($response, $code);
    }

    public function paginate($data = []){

        $paginationArray = NULL;
        if($data != NULL){

            // if($data->hasPages()){

            $items = array_values($data->items());


            $paginationArray = array ('list'=>$items,'pagination'=>[]);
            $paginationArray['pagination']['total'] = $data->total();
            $paginationArray['pagination']['current'] = $data->currentPage();
            $paginationArray['pagination']['first'] = 1;
            $paginationArray['pagination']['last'] = $data->lastPage();

            if($data->hasMorePages()) {
                if ( $data->currentPage() == 1) {
                    $paginationArray['pagination']['previous'] = 0;
                } else {
                    $paginationArray['pagination']['previous'] = $data->currentPage()-1;
                }
                $paginationArray['pagination']['next'] = $data->currentPage()+1;
            }
            else {
                $paginationArray['pagination']['previous'] = $data->currentPage()-1;
                $paginationArray['pagination']['next'] =  $data->lastPage();
            }
            if ($data->lastPage() > 1) {
                $paginationArray['pagination']['pages'] = range(1,$data->lastPage());
            }
            else {
                $paginationArray['pagination']['pages'] = [1];
            }
            $paginationArray['pagination']['from'] = $data->firstItem();
            $paginationArray['pagination']['to'] = $data->lastItem();
            //$paginationArray;
            //
            return $this->result = $paginationArray;

            /// }else {
            //     $paginationArray = $data;
            //     return $this->result = $paginationArray;
            // }
        }
        //return $paginationArray;
    }
}
