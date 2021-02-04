<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;
use App\User;
use App\FamilyPlanTypeSubcategories;
use App\AdsManagement;
use App\ClickAds;
use App\ViewAds;
use App\Clinics;
use App\ClinicGallery;
use App\ClinicService;
use App\ClinicTime;
use App\PaidServices;
use App\FpmTypeService;
use App\Ratings;
use App\RatingDetails;
use App\Staffs;
use App\Patients;
use App\PatientTimeSlot;
use App\Spouses;
use App\EventsNotification;
use App\Booking;
use App\BookingTime;
use App\ChatBot;
use App\ChatBotResponse;
use App\Survey;
use App\MedicalHistory;
use App\MedicalHistoryAnswer;

class TruncateData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        User::where('role_id', 2)->delete();
        User::where('role_id', 3)->delete();
        User::where('role_id', 4)->delete();
        FamilyPlanTypeSubcategories::query()->truncate();
        AdsManagement::query()->truncate();
        ClickAds::query()->truncate();
        ViewAds::query()->truncate();
        Clinics::query()->truncate();
        ClinicGallery::query()->truncate();
        ClinicService::query()->truncate();
        ClinicTime::query()->truncate();
        PaidServices::query()->truncate();
        FpmTypeService::query()->truncate();
        Ratings::query()->truncate();
        RatingDetails::query()->truncate();
        Staffs::query()->truncate();
        Patients::query()->truncate();
        PatientTimeSlot::query()->truncate();
        Spouses::query()->truncate();
        EventsNotification::query()->truncate();
        Booking::query()->truncate();
        BookingTime::query()->truncate();
        ChatBotResponse::query()->truncate();
        ChatBot::query()->truncate();
        Survey::query()->truncate();
        MedicalHistory::query()->truncate();
        MedicalHistoryAnswer::query()->truncate();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
