<?php

namespace App\Http\Controllers\AppApiControllers;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

use App\Models\AdminModels\TriviaContest;
use App\Models\AdminModels\Contest;
use App\Models\AdminModels\ContestParticipate;
use App\Models\User;

class ContestController extends Controller
{
    public function __construct(){

    }

    public function getContestDetails(){
        request()->merge(['token' => Crypt::decryptString(request()->token)]);
        request()->merge(['user_id' => Crypt::decryptString(request()->user_id)]);
        request()->merge(['contest_id' => Crypt::decryptString(request()->contest_id)]);
        request()->merge(['type' => Crypt::decryptString(request()->type)]);

        // validation
        $validator = Validator::make(request()->all(),[
            'token' => 'required',
            'user_id' => 'required',
            'contest_id' => 'required',
            'type' => 'required',
        ]);

        if ($validator->fails()) {
            return Crypt::encryptString(json_encode(array("error"=>"Invalid token.")));
        }
        else{
            $user = User::where([['token',request()->token],['id',request()->user_id]]);
            if ($user->count()) {
                $contest = Contest::where([['id',request()->contest_id],['active','1'],['form_date','<=',date('Y-m-d 00:00:00')],['to_date','>=',date('Y-m-d 23:59:59')]]);
                if ($contest->count() == 0){
                    $message = array("error"=>"No contest found!");
                    return Crypt::encryptString(json_encode($message));
                }else{
                    $contest = $contest->first();
                    $contest->connectedDine = $contest->dines->pluck('dineDetails');
                    $contest->dine_count = $contest->dines->count();
                    $contest->connectedFC = $contest->fc_outlets->pluck('dineDetails');
                    $contest->fc_count = $contest->fc_outlets->count();

                    if(request('type') == '0'){
                        if($contest->fc_count == 0) request()->merge(['type' => 1]); 
                    }elseif(request('type') == '1'){
                        if($contest->dine_count == 0) request()->merge(['type' => 0]); 
                    }

                    $contest->userCount = $contest->participants->where('user_id',request()->user_id)->count();
                    if ($contest->userCount <> 0){

                    	$sdate = date("Y-m-01");
                    	$edate = date("Y-m-t");
                        $contest->userTransactionAll = $contest->participants
                                                        ->where('user_id',request()->user_id)
                                                        ->first()
                                                        ->transactions
                                                        ->where('type',request()->type)
                                                        ->whereBetween('trans_date', [$sdate,$edate])
                                                        ->all();
                    	if(request('timestamp')){
                    		$sdate=date("Y-m-01",intval(Crypt::decryptString(request()->timestamp)));
                    		$edate=date("Y-m-t",intval(Crypt::decryptString(request()->timestamp)));
                        	$contest->userTransactionAll = $contest->participants
                                                            ->where('user_id',request()->user_id)
                                                            ->first()
                                                            ->transactions
                                                            ->where('type',request()->type)
                                                            ->whereBetween('trans_date', [$sdate,$edate])
                                                            ->all();
	                    	if(request('week')){
	                    		$edate=$this->LastDayofWeek(Crypt::decryptString(request()->week),intval(Crypt::decryptString(request()->timestamp)));
	                    	}
                    	}

                        $contest->userCode = $contest->participants->where('user_id',request()->user_id)->first()->unique_code;
                        $contest->userJoinDate = $contest->participants->where('user_id',request()->user_id)->first()->participation_date;

                        $contest->userTransaction = $contest->participants
                                                        ->where('user_id',request()->user_id)
                                                        ->first()
                                                        ->transactions
                                                        ->where('type',request()->type)
                                                        ->whereBetween('trans_date', [$sdate,$edate])
                                                        ->all();
                        foreach ($contest->userTransaction as $key => $value) {
                        	$value->dineDetails;
                        }

                        $contest->userTransaction = array_values($contest->userTransaction);
                        $contest->userTransactionAll = array_values($contest->userTransactionAll);

                        $contest->thresholdDetails = $contest->thresholdDetails->where('type',request()->type)->pluck("percentage");
                    }

                    return Crypt::encryptString(json_encode($contest->toArray()));
                }
            }else return Crypt::encryptString(json_encode(array("error"=>"Invalid token.")));
        }
    }

    private function genCode($id){
        $char = "ABCDEFGHIZKLMNOPQRSTUVWXYZ0123456789";
        $code = substr(str_shuffle($char),1,7);

        if(ContestParticipate::where([['unique_code',$code],['contest_id',$id]])->count() == 0) return $code;
        else return $this->genCode($id);
    }

     public function joinContest(){
        request()->merge(['token' => Crypt::decryptString(request()->token)]);
        request()->merge(['user_id' => Crypt::decryptString(request()->user_id)]);
        request()->merge(['contest_id' => Crypt::decryptString(request()->contest_id)]);
        request()->merge(['type' => Crypt::decryptString(request()->type)]);

        // validation
        $validator = Validator::make(request()->all(),[
            'token' => 'required',
            'user_id' => 'required',
            'contest_id' => 'required',
            'type' => 'required',
        ]);

        if ($validator->fails()) {
            return Crypt::encryptString(json_encode(array("error"=>"Invalid token.")));
        }
        else{
            $user = User::where([['token',request()->token],['id',request()->user_id]]);
            if ($user->count()) {
                $contest = Contest::where([['id',request()->contest_id],['active','1'],['form_date','<=',date('Y-m-d 00:00:00')],['to_date','>=',date('Y-m-d 23:59:59')]]);
                if ($contest->count() == 0){
                    $message = array("error"=>"No contest found!");
                    return Crypt::encryptString(json_encode($message));
                }else{
                    if(ContestParticipate::where([['contest_id',request()->contest_id],['user_id',request()->user_id]])->count() == 0){
                    	$addarr = array(
                    		"user_id" => request()->user_id,
                    		"contest_id" => request()->contest_id,
                    		"unique_code" => $this->genCode(request()->contest_id),
                    		"participation_date" => date('Y-m-d'),
                    	);
                    	ContestParticipate::create($addarr);
                    }

                	request()->merge(['token' => Crypt::encryptString(request()->token)]);
			        request()->merge(['user_id' => Crypt::encryptString(request()->user_id)]);
			        request()->merge(['contest_id' => Crypt::encryptString(request()->contest_id)]);
                    request()->merge(['type' => Crypt::encryptString(request()->type)]);
                    return $this->getContestDetails();
                }
            }else return Crypt::encryptString(json_encode(array("error"=>"Invalid token.")));
        }
    }

    private function LastDayofWeek($week,$timestamp){
    	$begin  = new \DateTime(date('Y-m-01', $timestamp));
		$end    = new \DateTime(date('Y-m-t', $timestamp));
		$month = date('m', $timestamp);
    	$weeks = [];

		while ($begin <= $end)
		{
			if($begin->format("d") == "01"){
		    	array_push($weeks, date("Y-m-d" ,strtotime('first Saturday of '.$begin->format("Y-m-d"))));
			}
		    elseif($begin->format("D") == "Sun")
		    {
		    	if (date( "m" ,strtotime('+6 days'.$begin->format("Y-m-d"))) <> $month){
		    		array_push($weeks, date("Y-m-t",$timestamp));
		    	}else{
		    		array_push($weeks, date("Y-m-d" ,strtotime('+6 days'.$begin->format("Y-m-d"))));
		    	}
		    }

		    $begin->modify('+1 day');
		    if ($begin->format("m") <> $month) break;
		}

		return $weeks[$week-1];
    }



    // trivia contest
    private function questions($date, $answer=false){
        return [""];

        $date = \Carbon::parse('2020-10-22');
        $day = $date->diffInDays(\Carbon::now()) + 1;

        if ($day == 1){
            return [
                ['question'=>'Quest is located in the _____', 'options'=>['Pink city','City of Joy','City of dreams'], 'answer' => 'City of Joy'],
                ['question'=>'Which among the following is a Japanese fine dine restaurant at Quest.', 'options'=>['Q33','Aajisai','SKAI'], 'answer' => 'Aajisai '],
                ['question'=>'What do we call the fourth day of Pujo? ', 'options'=>['Panchami','Dwitiya','Chaturthi'], 'answer' => 'Chaturthi'],
                ['question'=>'I am an Italian luxury menswear brand at Quest. Who am I? ', 'options'=>['Coach','Canali','Forever New'], 'answer' => 'Canali'],
                ['question'=>'On which floor at Quest will you find Label Ritu Kumar? ', 'options'=>['Basement','First Floor','Second Floor'], 'answer' => 'Second Floor '],
                ['question'=>'Which brand at Quest starts with the letter O and is a contemporary womenswear brand?', 'options'=>['Omega','Only','Boss'], 'answer' => 'Only'],
                ['question'=>'Durga Puja is held during which season?', 'options'=>['Autumn','Spring','Monsoon'], 'answer' => 'Autumn']
            ];
        }elseif ($day == 2){
            return [
                ['question'=>'In which year was Quest launched?', 'options'=>['2017','2012','2013'], 'answer' => "2013"],
                ['question'=>'Which among the following is a Mexican fine dine restaurant at Quest? ', 'options'=>["Indigo", "Chili’s", "Bombay Brasserie"], 'answer' => "Chili's"],
                ['question'=>'Which flower is symbolic to pujo? ', 'options'=>["Hibiscus",'Kash','Jasmine'], 'answer' => "Kash"],
                ['question'=>'I am a famous luxury skincare brand at Quest. Who am I? ', 'options'=>['Clinique','Boss','Lacoste'], 'answer' => "Clinique"],
                ['question'=>'On which floor at Quest will you find Aldo?', 'options'=>['Basement','First Floor','Second Floor'], 'answer' => "First Floor"],
                ['question'=>'I was born out of Florence. I am one of the most famous luxury brands in the world. Who am I?', 'options'=>['Gucci','TUMI',"TOD's"], 'answer' => "Gucci"],
                ['question'=>'On which day do we immerse the idol of Goddess Durga?', 'options'=>['Dashami','Sashti','Panchami'], 'answer' => "Dashami"]
            ];
        }elseif ($day == 3){
            return [
                ['question'=>'Quest is Kolkata’s only _______', 'options'=>['luxury lifestyle mall','mall with a food court','mall with a large parking area'], 'answer' => 'luxury lifestyle mall'],
                ['question'=>'Which most-loved Taco franchise is now a part of Quest?', 'options'=>['Burger King','Taco Bell','Bombay Toastee'], 'answer' => 'Taco Bell'],
                ['question'=>'Who does Goddess Durga slay in her iconic sculptures?', 'options'=>['Mahisasur','Ganesha','A snake'], 'answer' => 'Mahisasur'],
                ['question'=>'I am a famous premium accessory brand at Quest. Who am I?', 'options'=>['Dune','Nykaa Luxe','Levis'], 'answer' => 'Dune'],
                ['question'=>'On which floor at Quest will you find Allen Solly?', 'options'=>['Basement','First Floor','Second Floor'], 'answer' => 'Second Floor'],
                ['question'=>'I am one of the most famous sportswear brands in the world. Who am I?', 'options'=>['Puma','Rare Rabbit','Calvin Klein'], 'answer' => 'Puma'],
                ['question'=>'How many kids does Goddess Durga have?', 'options'=>['4','1','2'], 'answer' => '4']
            ];
        }elseif ($day == 4){
            return [
                ['question'=>'Social distancing is a must at Quest! How many people are allowed at a time in our elevators?', 'options'=>['5','3','7'], 'answer' => '3'],
                ['question'=>'This ice cream brand at Quest has been making ice cream like no other since 1961.', 'options'=>['ROYCE’','Haagen-Dazs','Coffee Bean & Tea Leaf'], 'answer' => 'Haagen-Dazs'],
                ['question'=>'Who does Goddess Durga ride?', 'options'=>['A peacock','A mouse','A lion'], 'answer' => 'A lion'],
                ['question'=>'I am a brand at Quest that makes boho Indian youth inspired apparel. Who am I? ', 'options'=>['Crocs','Diesel','Global Desi'], 'answer' => 'Global Desi'],
                ['question'=>'On which floor at Quest will you find Emporio Armani? ', 'options'=>['Basement','Ground Floor','Second Floor'], 'answer' => 'Ground Floor'],
                ['question'=>'I make exquisite crystal jewellery. Which brand am I?', 'options'=>['Forest Essentials','Swarovski','Lifestyle'], 'answer' => 'Swarovski'],
                ['question'=>'What else is popularly celebrated during the nine days of Pujo in other parts of the country?', 'options'=>['Christmas','Navrati','Holi'], 'answer' => 'Navrati']
            ];
        }elseif ($day == 5){
            return [
                ['question'=>'What is Quest’s shop from home facility called?', 'options'=>['Just Pick Up','Port it',"Pick Up & Porter"], 'answer' => "Pick Up & Porter"],
                ['question'=>'I am a part of Quest and I make delicious Belgian Waffles', 'options'=>['Juices & More','Waffle Wallah',"Bombay Brasserie"], 'answer' => "Waffle Wallah"],
                ['question'=>'Which of the following is another name for Durga?', 'options'=>['Uma','Lakshmi',"Shobha"], 'answer' => "Uma"],
                ['question'=>'I am an iconic American denim brand at Quest. Who am I?', 'options'=>['Lifestyle','Armani Exchange',"Levi's"], 'answer' => "Levi's"],
                ['question'=>'On which floor at Quest will you find Estee Lauder?', 'options'=>['Basement','First Floor',"Second Floor"], 'answer' => "First Floor"],
                ['question'=>'I made the iconic beach sandals and flip flops famous. Which brand at Quest am I?', 'options'=>['Inc. 5','Crocs',"Adidas"], 'answer' => "Crocs"],
                ['question'=>'Who among Goddess Durga’s kids plays the Veena?', 'options'=>['Ganesha','Saraswati',"Lakshmi"], 'answer' => "Saraswati"]
            ];
        }elseif ($day == 6){
            return [
                ['question'=>'Which of the following movie theatres is at Quest?', 'options'=>['PVR','INOX','FAME'], 'answer' => 'INOX'],
                ['question'=>'What is the name of the rooftop restaurant and premium lounge at Quest?', 'options'=>['SKAI','Serafina','Indigo Delicatessen'], 'answer' => 'SKAI'],
                ['question'=>'Who resides at Kailash and is married to Goddess Durga?', 'options'=>['Brahma','Shiva','Vishnu'], 'answer' => 'Shiva'],
                ['question'=>'I am a brand at Quest. My name is a conjunction in English. Who am I?', 'options'=>['Bally','AND','Change'], 'answer' => 'AND'],
                ['question'=>'On which floor at Quest will you find Bose ?', 'options'=>['Basement','First Floor','Third Floor'], 'answer' => 'Third Floor'],
                ['question'=>'I believe in upholding the rich traditions of India and supporting Indian artisans. Which brand at Quest am I?', 'options'=>['Fabindia','Delsey','Burberry'], 'answer' => 'Fabindia'],
                ['question'=>'What is the yummy khichdi served for Pujo called?', 'options'=>['Feast','Bhog','Sondesh'], 'answer' => 'Bhog']
            ];
        }elseif ($day == 7){
            return [
                ['question'=>'Which famous toy shop is a part of Quest?', 'options'=>['Accessorize',"Hamley's","Kiehl’s"], 'answer' => "Hamley's"],
                ['question'=>'This restaurant at Quest has the finest Italian food in town.', 'options'=>['Aajisai',"Serafina","Yauatcha"], 'answer' => "Serafina"],
                ['question'=>'When did the first recorded Durga Puja take place in Kolkata?', 'options'=>['2000',"1909","1990"], 'answer' => "1909"],
                ['question'=>'I am a brand at Quest and I believe in classic American cool style. Who am I?', 'options'=>['Fabindia',"Tommy Hilfiger","Mothercare"], 'answer' => "Tommy Hilfiger"],
                ['question'=>'On which floor at Quest will you find Isharya?', 'options'=>['Ground Floor',"First Floor","Fourth Floor"], 'answer' => "Ground Floor"],
                ['question'=>'My logo has a crocodile in it. Which brand at Quest am I?', 'options'=>['Nautica',"United Colors of Benetton","Lacoste"], 'answer' => "Lacoste"],
                ['question'=>'The sound of this musical instrument is heard at every pandal. What is it?', 'options'=>['Mridangam',"Dhak","Sitar"], 'answer' =>"Dhak"]
            ];
        }else{
            return [];
        }
    }
    public function getTriviaDetails(){
        request()->merge(['token' => Crypt::decryptString(request()->token)]);
        request()->merge(['user_id' => Crypt::decryptString(request()->user_id)]);

        // validation
        $validator = Validator::make(request()->all(),[
            'token' => 'required',
            'user_id' => 'required',
        ]);

        if ($validator->fails()) {
            return Crypt::encryptString(json_encode(array("error"=>"Invalid token.")));
        }
        else{
            $user = User::where([['token',request()->token],['id',request()->user_id]]);
            if ($user->count()) {

                // 'submitted'=> TriviaContest::where('user_id',request()->user_id)->whereDate('created_at', date('Y-m-d'))->count(),
                // 'submittedmessage'=>"Thank you!\nCome back for tomorrow’s trivia to win more!\nWe are announcing winners everyday on Quest’s social handles.\n@QuestMall\n@QuestMallOficial",
                // 'button_name'=>'Participate Now',

                $contest = array(
                    'button_name'=>'The Contest is Over',
                    'name'=>'Trivia Contest',
                    'thankyoumsg'=>"Thank you for participating in the Win Big Q-Pujo Trivia.\nFollow Quest on\nInstagram: @questmall\nFacebook: @questmallofficial\nFor winner announcements.",
                    'submitted'=> 1,
                    'submittedmessage'=>"Thank you for participating!\nThe contest is over.\nFollow Quest on\nInstagram: @questmall\nFacebook: @questmallofficial\nFor winner announcements.",
                    'terms'=>'<p>1. The trivia can only be performed on the Quest App. Hence, downloading the app to perform the trivia is mandatory.</p><p>2. All questions are mandatory.</p><p>3. All questions are multi-choice from which you have to choose.</p><p>4. The trivia will run only for 7 days of the Durga Puja week.</p><p>5. All winners will be announced on Quest social media handles: <br>&nbsp;&nbsp;&nbsp;&nbsp;Instagram: @questmall<br>&nbsp;&nbsp;&nbsp;&nbsp;Facebook: @questmallofficial</p><p>6. The winners will be announced every day.</p><p>7. The winners can claim and pick-up their vouchers, by messaging us on facebook or instagram. </p><p>8. The voucher that will be given to the winner is a Rs 1000 Adidas voucher.</p>',
                    'image'=>'App-Banner2.jpg',
                    'content'=>'<p>Quest brings you the most exciting chance to win the biggest offers of the season. All you have to do is answer simple questions about Quest and win vouchers.</p><p>Participate in the Win Big Q-Pujo Trivia.</p><p>Winners to be announced on Quest’s Facebook and Instagram</p><h4>Instructions on how to play:</h4><p>• All questions are compulsory<br>• Each question is a multiple choice question with three options as probable answers<br>• Choose your answer by clicking on it and then swipe to the next question<br>• Answers can be changed by swiping back to questions<br>• There is no time limit to submit the answers<br>• Once you are done answering all questions satisfactorily, click on submit</p><p>Begin the Win Big Q-Pujo Trivia</p>',
                    'questions'=> $this->questions(date('Y-m-d')),
                );

                return Crypt::encryptString(json_encode($contest));
            }else return Crypt::encryptString(json_encode(array("error"=>"Invalid token.")));
        }
    }

    public function submitTrivia()
    {
        request()->merge(['token' => Crypt::decryptString(request()->token)]);
        request()->merge(['user_id' => Crypt::decryptString(request()->user_id)]);
        request()->merge(['questions' => Crypt::decryptString(request()->questions)]);
        request()->merge(['questions' => substr(request()->questions,0,strlen(request()->questions)-3)]);
        request()->merge(['answers' => Crypt::decryptString(request()->answers)]);
        request()->merge(['answers' => substr(request()->answers,0,strlen(request()->answers)-3)]);

        // validation
        $validator = Validator::make(request()->all(),[
            'token' => 'required',
            'user_id' => 'required',
            'questions' => 'required',
            'answers' => 'required',
        ]);

        if ($validator->fails()) {
            return Crypt::encryptString(json_encode(array("error"=>"Invalid token.")));
        }
        else{
            $user = User::where([['token',request()->token],['id',request()->user_id]]);
            if ($user->count()) {
                if (TriviaContest::where('user_id',request()->user_id)->whereDate('created_at', date('Y-m-d'))->count() == 0){
                    $questions = $this->questions(date('Y-m-d'),true);
                    $sub_ans = explode("|||", request()->answers);
                    $score = 0;
                    foreach ($questions as $key=>$value) if($value['answer'] == $sub_ans[$key]) $score = $score+1;
                    request()->merge(['score' => $score]);

                    TriviaContest::create(request()->all());
                }
                return Crypt::encryptString(json_encode(array("success"=>"done")));
            }else return Crypt::encryptString(json_encode(array("error"=>"Invalid token.")));
        }
    }
}
