<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Members_Controller extends MY_Controller
{
    protected $me;

    public function __construct()
    {
        parent::__construct();
        if ($this->ion_auth->logged_in() == false) {
            redirect(base_url());
        }
        $this->me = $this->ion_auth->user()->row();
        $this->config->set_item('active', $this->me->active);
    }

    protected function makeMemberUrl($member_id, $profile_url)
    {
        $url = base_url() . $member_id;
        if (isset($profile_url) && $profile_url != '') {
            $url = base_url() . $profile_url;
        }
        if ($member_id == $this->session->userdata('user_id')) {
            $url = base_url() . 'dashboard/myprofile';
        }
        return $url;
    }

    protected function checkFreeLuv()
    {
        $this->load->model('luv_model');
        $freeLuv = $this->luv_model->getLastFreeLuv();
        if (count($freeLuv) < 3) {
            return 3 - count($freeLuv);
        } else {
            $date = new DateTime($freeLuv[count($freeLuv) - 1]->sent_at);
            $now = new DateTime(gmdate("Y-m-d  H:i:s"));
            $now->sub(new DateInterval('PT24H'));
            $interval = $now->diff($date);
            return $this->intervalToString($interval);
        }
    }

    protected function intervalToString($interval)
    {
        $y = 'years';
        if ($interval->y == 1) {
            $y = 'year';
        }
        $m = 'months';
        if ($interval->m == 1) {
            $m = 'month';
        }
        $d = 'days';
        if ($interval->d == 1) {
            $d = 'day';
        }
        $h = 'hours';
        if ($interval->h == 1) {
            $h = 'hour';
        }
        $i = 'minutes';
        if ($interval->i == 1) {
            $i = 'minute';
        }
        $s = 'seconds';

        $string = '';
        if ($interval->y == 0) {
            if ($interval->m == 0) {
                if ($interval->d == 0) {
                    if ($interval->h == 0) {
                        if ($interval->i == 0) {
                            $string = "$interval->s $s";
                        } else {
                            $string = "$interval->i $i";
                        }
                    } else {
                        $string = "$interval->h $h $interval->i $i";
                    }
                } else {
                    $string = "$interval->d $d";
                }
            } else {
                $string = "$interval->m $m";
            }
        } else {
            $string = "$interval->y $y $interval->m $m";
        }
        return $string;
    }

    protected function convertToUserTimezone($dateTimeString)
    {
        $date = new DateTime($dateTimeString);
        $offset = isset($_SESSION['timezoneOffset']) ? intval($_SESSION['timezoneOffset']) : false;
        if ($offset) {
            $interval = new DateInterval('PT' . abs($offset) . 'M');//set interval in minutes
            if ($offset < 0) {
                $interval->invert = 1;
            }
            $date->add($interval);
            return $date->format('Y-m-d H:i:s');
        } else {
            return $dateTimeString;
        }
    }

    protected function getTopText()
    {
        $this->load->model('admin_model');
        $temp = $this->getTimeOfDayData();
        $data = (object)['text' => $this->admin_model->getTopText($temp->key),
            'image' => $temp->image];
        return $data;
    }

    private function getTimeOfDayData()
    {
        $userTime = strtotime($this->convertToUserTimezone(date("Y-m-d H:i:s")));
        $hour = intval(date('H', $userTime));
        $data = (object)[];
        if ($hour >= 17 && $hour <= 19) {
            $data->key = 'evening5pm_7pm';
            $data->image = 'evening.png';
            return $data;
        } elseif ($hour >= 20 && $hour <= 22) {
            $data->key = 'night8pm_10pm';
            $data->image = 'night.png';
            return $data;
        } elseif ($hour >= 23 && $hour < 1) {
            $data->key = 'night11pm_12am';
            $data->image = 'night.png';
            return $data;
        } elseif ($hour >= 1 && $hour <= 3) {
            $data->key = 'night1am_3am';
            $data->image = 'night.png';
            return $data;
        } elseif ($hour >= 4 && $hour <= 5) {
            $data->key = 'night3am_6m';
            $data->image = 'night.png';
            return $data;
        } elseif ($hour >= 6 && $hour <= 7) {
            $data->key = 'morning6am_8am';
            $data->image = 'morning.png';
            return $data;
        } elseif ($hour >= 8 && $hour < 9) {
            $data->key = 'morning8am_9am';
            $data->image = 'morning.png';
            return $data;
        } elseif ($hour >= 9 && $hour <= 11) {
            $data->key = 'morning9am_11am';
            $data->image = 'morning.png';
            return $data;
        } elseif ($hour >= 12 && $hour <= 14) {
            $data->key = 'afternoon12pm_2pm';
            $data->image = 'afternoon.png';
            return $data;
        } elseif ($hour >= 16 && $hour < 17) {
            $data->key = 'afternoon4pm_5pm';
            $data->image = 'afternoon.png';
            return $data;
        } else {
            $data->key = 'afternoon3pm_4pm';
            $data->image = 'afternoon.png';
            return $data;
        }
    }

    protected function sendEmail($to, $subject, $body)
    {
        $headers = "From: Orriz<noreply@orriz.com>\n";
        $headers .= "MIME-Version: 1.0\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1";
        $send = mail($to, $subject, $body, $headers);
        if ($send) {
            return "Invitation sent Successfully";
        } else {
            return "Something went wrong!";
        }
    }

}
