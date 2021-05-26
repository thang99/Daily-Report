<?php
namespace App\Http\Services;

use App\Repositories\Contracts\FeedBackRepository;

class FeedBackService
{
   protected $feedbackRepository;

   public function __construct(FeedBackRepository $feedbackRepository)
   {
        $this->feedbackRepository = $feedbackRepository;    
   }
   
   public function storeFeedBack($data)
   {
        try {
            $result = $this->feedbackRepository->create($data);

            return $result;
        } catch(\Exception $e) {
            $message = $e->getMessage();

            return $message;
        }
   }
}