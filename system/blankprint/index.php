<?php
ini_set("memory_limit", "128M");
define("FPDF_FONTPATH", 'font/');
define("FPDF_LIBPATH", '');
define("SAMPLES_PATH", 'samples/');
require(FPDF_LIBPATH . 'fpdf.php');

class PDF_Blank116_origin extends FPDF
{
    function PrintPage($title)
    {
        $this->SetTitle($title);
        $this->AddFont('TimesNRCyrMT', '', 'timcyr.php');
        $this->AddPage('L');
        $this->Image(SAMPLES_PATH . 'blank116.jpg', 0, 1, 145, 206);
    }

    function PrintPage2()
    {
        $this->Image(SAMPLES_PATH . 'blank116_2.jpg', 151, 1, 145, 206);
    }

    function PrintClientIndex($indx)
    {
        $v = 0.71345;
        $h = 0.6868;
        $indx = tocp1251($indx);
        if (isset($indx) and (mb_strlen($indx, 'windows-1251') >= 1)) {
            $i = 0;
            while ($i <= (mb_strlen($indx, 'windows-1251') - 1)) {
                $this->SetFont('TimesNRCyrMT', '', 20);
                $this->SetXY(97.3 * $h + $i * 4.95, 114.9 * $v);
                $this->Cell(0, 0, $indx[$i]);
                $this->SetXY(149.4 * $h + $i * 4.80, 189.5);
                $this->Cell(0, 0, $indx[$i]);
                $i++;
            }
        }
    }

    function PrintShopIndex($indx)
    {
        $v = 0.71345;
        $h = 0.6168;
        $indx = tocp1251($indx);
        if (isset($indx) and (mb_strlen($indx, 'windows-1251') >= 1)) {
            $i = 0;
            while ($i <= (mb_strlen($indx, 'windows-1251') - 1)) {
                $this->SetFont('TimesNRCyrMT', '', 19);
                $this->SetXY(102.6 + $i * 4.95, 101.8);
                $this->Cell(0, 0, $indx[$i]);
                $i++;
            }
        }
    }

    function PrintClientName($name)
    {
        $this->SetFont('TimesNRCyrMT', '', 11);
        $name = tocp1251($name);
        $v = 0.70245;
        $h = 0.6168;
        $this->SetXY(27 * $h, 92.4 * $v);
        $this->Cell(0, 0, $name);
        $this->SetXY(26 * $h, 248.9 * $v);
        $this->Cell(0, 0, $name);
    }

    function PrintShopName($name)
    {
        $v = 0.70245;
        $h = 0.6168;
        $this->SetFont('TimesNRCyrMT', '', 11);
        $name = tocp1251($name);
        $this->SetXY(32 * $h, 127.8 * $v);
        $this->Cell(0, 0, $name);
    }

    function PrintShopAddr($address)
    {
        $this->SetFont('TimesNRCyrMT', '', 11);
        $address = tocp1251($address);
        $ans = multiStr($address, array(60));
        $this->SetXY(18, 96.5);
        $this->Cell(0, 0, $ans[0]);
        $this->SetXY(10, 102.0);
        $this->Cell(0, 0, $ans[1]);
        $ans = multiStr($address, array(70));
    }

    function PrintClientAddr($address)
    {
        $this->SetFont('TimesNRCyrMT', '', 11);
        $address = tocp1251($address);
        $ans = multiStr($address, array(41, 47));
        $this->SetXY(18.5, 70.1);
        $this->Cell(0, 0, $ans[0]);
        $this->SetXY(9, 70.1 + 6);
        $this->Cell(0, 0, $ans[1]);
        $this->SetXY(9, 70.1 + 13);
        $this->Cell(0, 0, $ans[2]);
        $ans = multiStr($address, array(60));
        $this->SetXY(18, 182.5);
        $this->Cell(0, 0, $ans[0]);
        $this->SetXY(10, 189.9);
        $this->Cell(0, 0, $ans[1]);
    }

    function PrintSumObStr($sum)
    {
        $this->SetFont('TimesNRCyrMT', '', 13);
        $this->SetXY(36, 166.8);
        $this->Cell(0, 0, $sum);
        $sumstr = tocp1251("(" . propis(floatval($sum), false) . ") руб.");
        $this->SetXY(8.5, 50.0);
        $this->Cell(0, 0, $sum);
        $l = strlen(strval($sum));
        $sumstr = multiStr($sumstr, array(60 - $l * 3));
        if (isset($sumstr[1])) {
            $this->SetFont('TimesNRCyrMT', '', 9);
            $this->SetXY(8 + $l * 2.7, 48.3);
            $this->Cell(0, 0, $sumstr[0]);
            $this->SetXY(8 + $l * 2.7, 51.1);
            $this->Cell(0, 0, $sumstr[1]);
        } else {
            $this->SetFont('TimesNRCyrMT', '', 10);
            $this->SetXY(8 + $l * 2.7, 50.0);
            $this->Cell(0, 0, $sumstr[0]);
        }
    }

    function PrintSumNalStr($sum)
    {
        $this->SetFont('TimesNRCyrMT', '', 13);
        $this->SetXY(104, 166.8);
        $this->Cell(0, 0, $sum);
        $sumstr = tocp1251("(" . propis(floatval($sum), false) . ") руб.");
        $this->SetXY(8.5, 58.5);
        $this->Cell(0, 0, $sum);
        $l = strlen(strval($sum));
        $sumstr = multiStr($sumstr, array(60 - $l * 3));
        if (isset($sumstr[1])) {
            $this->SetFont('TimesNRCyrMT', '', 9);
            $this->SetXY(8 + $l * 2.7, 56.8);
            $this->Cell(0, 0, $sumstr[0]);
            $this->SetXY(8 + $l * 2.7, 59.6);
            $this->Cell(0, 0, $sumstr[1]);
        } else {
            $this->SetFont('TimesNRCyrMT', '', 10);
            $this->SetXY(8 + $l * 2.7, 58.5);
            $this->Cell(0, 0, $sumstr[0]);
        }
    }

    function PrintShopDocument($document, $ser, $nomer, $data, $org)
    {
        $this->SetFont('TimesNRCyrMT', '', 11);
        $document = tocp1251($document);
        $ser = tocp1251($ser);
        $org = tocp1251($org);
        $nomer = tocp1251($nomer);
        $data = tocp1251($data);
        $data = explode("-", $data);
        $this->SetXY(26, 115.5);
        $this->Cell(0, 0, $document);
        $this->SetFont('TimesNRCyrMT', '', 13);
        $this->SetXY(56, 115.5);
        $this->Cell(0, 0, $ser);
        $this->SetXY(74, 115.5);
        $this->Cell(0, 0, $nomer);
        $this->SetFont('TimesNRCyrMT', '', 11);
        $this->SetXY(102, 115.5);
        $this->Cell(0, 0, $data[2] . "." . $data[1]);
        $this->SetXY(124.5, 115.5);
        $this->Cell(0, 0, substr($data[0], -2));
        $this->SetFont('TimesNRCyrMT', '', 11);
        $this->SetXY(10, 121.3);
        $this->Cell(0, 0, $org);
    }
}

class PDF_Blank112_a5 extends FPDF
{
    function PrintPage($title)
    {
        $this->SetTitle($title);
        $this->AddFont('TimesNRCyrMT', '', 'timcyr.php');
        $this->AddPage('L');
        $this->Image(SAMPLES_PATH . 'blank112.jpg', 151, 1, 145, 206);
    }

    function PrintClientIndex($indx)
    {
        $v = 0.71345;
        $h = 0.6868;
        $indx = tocp1251($indx);
        if (isset($indx) and (mb_strlen($indx, 'windows-1251') >= 1)) {
            $i = 0;
            while ($i <= (mb_strlen($indx, 'windows-1251') - 1)) {
                $this->SetFont('TimesNRCyrMT', '', 16);
                $this->SetXY(269.9 + $i * 3.55, 107.2);
                $this->Cell(0, 0, $indx[$i]);
                $i++;
            }
        }
    }

    function PrintShopIndex($indx)
    {
        $v = 0.71345;
        $h = 0.6168;
        $indx = tocp1251($indx);
        if (isset($indx) and (mb_strlen($indx, 'windows-1251') >= 1)) {
            $i = 0;
            while ($i <= (mb_strlen($indx, 'windows-1251') - 1)) {
                $this->SetFont('TimesNRCyrMT', '', 16);
                $this->SetXY(269.9 + $i * 3.55, 65.4);
                $this->Cell(0, 0, $indx[$i]);
                $i++;
            }
        }
    }

    function PrintClientName($name)
    {
        $this->SetFont('TimesNRCyrMT', '', 11);
        $name = tocp1251($name);
        $v = 0.70245;
        $h = 0.6168;
        $this->SetXY(167, 97.3);
        $this->Cell(0, 0, $name);
    }

    function PrintShopName($name)
    {
        $v = 0.70245;
        $h = 0.6168;
        $this->SetFont('TimesNRCyrMT', '', 11);
        $name = tocp1251($name);
        $this->SetXY(163, 55.7);
        $this->Cell(0, 0, $name);
    }

    function PrintShopAddr($address)
    {
        $this->SetFont('TimesNRCyrMT', '', 11);
        $address = tocp1251($address);
        $ans = multiStr($address, array(70));
        $this->SetXY(163, 60.6);
        $this->Cell(0, 0, $ans[0]);
        $this->SetXY(155, 65.5);
        $this->Cell(0, 0, $ans[1]);
    }

    function PrintClientAddr($address)
    {
        $this->SetFont('TimesNRCyrMT', '', 11);
        $address = tocp1251($address);
        $ans = multiStr($address, array(55));
        $this->SetXY(184, 102.5);
        $this->Cell(0, 0, $ans[0]);
        $this->SetXY(155, 107.4);
        $this->Cell(0, 0, $ans[1]);
    }

    function PrintShopPhone($phone)
    {
        $this->SetFont('TimesNRCyrMT', '', 13);
        $phone = tocp1251($phone);
        if (isset($phone) and (mb_strlen($phone, 'windows-1251') >= 1)) {
            $i = 0;
            while ($i <= (mb_strlen($phone, 'windows-1251') - 1)) {
                $this->SetXY(262.7 + $i * 2.86, 46.7);
                $this->Cell(0, 0, $phone[$i]);
                $i++;
            }
        }
    }

    function PrintClientPhone($phone)
    {
        $this->SetFont('TimesNRCyrMT', '', 13);
        $phone = tocp1251($phone);
        if (isset($phone) and (mb_strlen($phone, 'windows-1251') >= 1)) {
            $i = 0;
            while ($i <= (mb_strlen($phone, 'windows-1251') - 1)) {
                $this->SetXY(262.7 + $i * 2.86, 51.2);
                $this->Cell(0, 0, $phone[$i]);
                $i++;
            }
        }
    }

    function PrintSumNalStr($sum)
    {
        $this->SetFont('TimesNRCyrMT', '', 13);
        $this->SetXY(156.8, 43.4);
        $this->Cell(0, 0, $sum);
        $this->SetXY(175.8, 43.4);
        $this->Cell(0, 0, "00");
        $this->SetFont('TimesNRCyrMT', '', 18);
        $this->SetXY(155, 49.9);
        $this->Cell(0, 0, "X");
        $this->SetFont('TimesNRCyrMT', '', 11);
        $sumstr = tocp1251(propis(floatval($sum), true));
        $this->SetXY(189.8, 39.9);
        $this->Cell(0, 0, $sumstr);
    }

    function PrintShopInn($inn)
    {
        $this->SetFont('TimesNRCyrMT', '', 12);
        $inn = tocp1251($inn);
        if (isset($inn) and (mb_strlen($inn, 'windows-1251') >= 1)) {
            $i = 0;
            while ($i <= (mb_strlen($inn, 'windows-1251') - 1)) {
                $this->SetXY(163.5 + $i * 3.41, 83.9);
                $this->Cell(0, 0, $inn[$i]);
                $i++;
            }
        }
    }

    function PrintShopBankKs($indx)
    {
        $this->SetFont('TimesNRCyrMT', '', 12);
        $indx = tocp1251($indx);
        if (isset($indx) and (mb_strlen($indx, 'windows-1251') >= 1)) {
            $i = 0;
            while ($i <= (mb_strlen($indx, 'windows-1251') - 1)) {
                $this->SetXY(223.9 + $i * 3.39, 83.9);
                $this->Cell(0, 0, $indx[$i]);
                $i++;
            }
        }
    }

    function PrintShopBankRs($indx)
    {
        $this->SetFont('TimesNRCyrMT', '', 12);
        $indx = tocp1251($indx);
        if (isset($indx) and (mb_strlen($indx, 'windows-1251') >= 1)) {
            $i = 0;
            while ($i <= (mb_strlen($indx, 'windows-1251') - 1)) {
                $this->SetXY(168.5 + $i * 3.40, 92.85);
                $this->Cell(0, 0, $indx[$i]);
                $i++;
            }
        }
    }

    function PrintShopBankBik($indx)
    {
        $this->SetFont('TimesNRCyrMT', '', 12);
        $indx = tocp1251($indx);
        if (isset($indx) and (mb_strlen($indx, 'windows-1251') >= 1)) {
            $i = 0;
            while ($i <= (mb_strlen($indx, 'windows-1251') - 1)) {
                $this->SetXY(261.3 + $i * 3.380, 92.85);
                $this->Cell(0, 0, $indx[$i]);
                $i++;
            }
        }
    }

    function PrintShopBankName($name)
    {
        $this->SetFont('TimesNRCyrMT', '', 11);
        $name = tocp1251($name);
        $this->SetXY(186, 88.4);
        $this->Cell(0, 0, $name);
    }
}

class PDF_Blank116_2 extends FPDF
{
    function PrintPage($title)
    {
        $this->SetTitle($title);
        $this->AddFont('TimesNRCyrMT', '', 'timcyr.php');
        $this->AddPage('L');
        $this->Image(SAMPLES_PATH . 'blank116.jpg', 0, 1, 145, 206);
    }

    function PrintPage2()
    {
        $this->AddPage('L');
        $this->Image(SAMPLES_PATH . 'blank116_2.jpg', 151, 1, 145, 206);
    }

    function PrintClientIndex($indx)
    {
        $v = 0.71345;
        $h = 0.6868;
        $indx = tocp1251($indx);
        if (isset($indx) and (mb_strlen($indx, 'windows-1251') >= 1)) {
            $i = 0;
            while ($i <= (mb_strlen($indx, 'windows-1251') - 1)) {
                $this->SetFont('TimesNRCyrMT', '', 20);
                $this->SetXY(97.3 * $h + $i * 4.95, 114.9 * $v);
                $this->Cell(0, 0, $indx[$i]);
                $this->SetXY(149.4 * $h + $i * 4.80, 189.5);
                $this->Cell(0, 0, $indx[$i]);
                $i++;
            }
        }
    }

    function PrintShopIndex($indx)
    {
        $v = 0.71345;
        $h = 0.6168;
        $indx = tocp1251($indx);
        if (isset($indx) and (mb_strlen($indx, 'windows-1251') >= 1)) {
            $i = 0;
            while ($i <= (mb_strlen($indx, 'windows-1251') - 1)) {
                $this->SetFont('TimesNRCyrMT', '', 19);
                $this->SetXY(102.6 + $i * 4.95, 101.8);
                $this->Cell(0, 0, $indx[$i]);
                $i++;
            }
        }
    }

    function PrintClientName($name)
    {
        $this->SetFont('TimesNRCyrMT', '', 11);
        $name = tocp1251($name);
        $v = 0.70245;
        $h = 0.6168;
        $this->SetXY(27 * $h, 92.4 * $v);
        $this->Cell(0, 0, $name);
        $this->SetXY(26 * $h, 248.9 * $v);
        $this->Cell(0, 0, $name);
    }

    function PrintShopName($name)
    {
        $v = 0.70245;
        $h = 0.6168;
        $this->SetFont('TimesNRCyrMT', '', 11);
        $name = tocp1251($name);
        $this->SetXY(32 * $h, 127.8 * $v);
        $this->Cell(0, 0, $name);
    }

    function PrintShopAddr($address)
    {
        $this->SetFont('TimesNRCyrMT', '', 11);
        $address = tocp1251($address);
        $ans = multiStr($address, array(60));
        $this->SetXY(18, 96.5);
        $this->Cell(0, 0, $ans[0]);
        $this->SetXY(10, 102.0);
        $this->Cell(0, 0, $ans[1]);
        $ans = multiStr($address, array(70));
    }

    function PrintClientAddr($address)
    {
        $this->SetFont('TimesNRCyrMT', '', 11);
        $address = tocp1251($address);
        $ans = multiStr($address, array(41, 47));
        $this->SetXY(18.5, 70.1);
        $this->Cell(0, 0, $ans[0]);
        $this->SetXY(9, 70.1 + 6);
        $this->Cell(0, 0, $ans[1]);
        $this->SetXY(9, 70.1 + 13);
        $this->Cell(0, 0, $ans[2]);
        $ans = multiStr($address, array(60));
        $this->SetXY(18, 182.5);
        $this->Cell(0, 0, $ans[0]);
        $this->SetXY(10, 189.9);
        $this->Cell(0, 0, $ans[1]);
    }

    function PrintSumObStr($sum)
    {
        $this->SetFont('TimesNRCyrMT', '', 13);
        $this->SetXY(36, 166.8);
        $this->Cell(0, 0, $sum);
        $sumstr = tocp1251("(" . propis(floatval($sum), false) . ") руб.");
        $this->SetXY(8.5, 50.0);
        $this->Cell(0, 0, $sum);
        $l = strlen(strval($sum));
        $sumstr = multiStr($sumstr, array(60 - $l * 3));
        if (isset($sumstr[1])) {
            $this->SetFont('TimesNRCyrMT', '', 9);
            $this->SetXY(8 + $l * 2.7, 48.3);
            $this->Cell(0, 0, $sumstr[0]);
            $this->SetXY(8 + $l * 2.7, 51.1);
            $this->Cell(0, 0, $sumstr[1]);
        } else {
            $this->SetFont('TimesNRCyrMT', '', 10);
            $this->SetXY(8 + $l * 2.7, 50.0);
            $this->Cell(0, 0, $sumstr[0]);
        }
    }

    function PrintSumNalStr($sum)
    {
        $this->SetFont('TimesNRCyrMT', '', 13);
        $this->SetXY(104, 166.8);
        $this->Cell(0, 0, $sum);
        $sumstr = tocp1251("(" . propis(floatval($sum), false) . ") руб.");
        $this->SetXY(8.5, 58.5);
        $this->Cell(0, 0, $sum);
        $l = strlen(strval($sum));
        $sumstr = multiStr($sumstr, array(60 - $l * 3));
        if (isset($sumstr[1])) {
            $this->SetFont('TimesNRCyrMT', '', 9);
            $this->SetXY(8 + $l * 2.7, 56.8);
            $this->Cell(0, 0, $sumstr[0]);
            $this->SetXY(8 + $l * 2.7, 59.6);
            $this->Cell(0, 0, $sumstr[1]);
        } else {
            $this->SetFont('TimesNRCyrMT', '', 10);
            $this->SetXY(8 + $l * 2.7, 58.5);
            $this->Cell(0, 0, $sumstr[0]);
        }
    }

    function PrintShopDocument($document, $ser, $nomer, $data, $org)
    {
        $this->SetFont('TimesNRCyrMT', '', 11);
        $document = tocp1251($document);
        $ser = tocp1251($ser);
        $nomer = tocp1251($nomer);
        $org = tocp1251($org);
        $data = tocp1251($data);
        $data = explode("-", $data);
        $this->SetXY(26, 115.5);
        $this->Cell(0, 0, $document);
        $this->SetFont('TimesNRCyrMT', '', 13);
        $this->SetXY(56, 115.5);
        $this->Cell(0, 0, $ser);
        $this->SetXY(74, 115.5);
        $this->Cell(0, 0, $nomer);
        $this->SetFont('TimesNRCyrMT', '', 11);
        $this->SetXY(102, 115.5);
        $this->Cell(0, 0, $data[2] . "." . $data[1]);
        $this->SetXY(124.5, 115.5);
        $this->Cell(0, 0, substr($data[0], -2));
        $this->SetFont('TimesNRCyrMT', '', 11);
        $this->SetXY(10, 121.3);
        $this->Cell(0, 0, $org);
    }
}

class PDF_Blank7p2 extends FPDF
{
    function PrintPage($title)
    {
        $this->SetTitle($title);
        $this->AddFont('Pechkin', '', '400a3fdb79b131fc51c59e3bc235f2d6_index.php');
        $this->AddFont('TimesNRCyrMT', '', 'timcyr.php');
        $this->AddPage('P');
        $this->Image(SAMPLES_PATH . 'blank7p.jpg', 0, 0, 210, 145);
        $logo_path = SAMPLES_PATH . 'logo.png';
        if (file_exists($logo_path)) {
            $p = getimagesize($logo_path);
            $this->Image($logo_path, 10, 10, $p[0] / 5, $p[1] / 5);
        }
    }

    function PrintClientIndex($indx)
    {
        $this->SetFont('TimesNRCyrMT', '', 30);
        $indx = tocp1251($indx);
        if (isset($indx) and (mb_strlen($indx, 'windows-1251') >= 1)) {
            $i = 0;
            while ($i <= (mb_strlen($indx, 'windows-1251') - 1)) {
                $this->SetFont('Pechkin', '', 42);
                $this->SetXY(26 + $i * 11.15, 125);
                $this->Cell(0, 0, $indx[$i]);
                $this->SetFont('TimesNRCyrMT', '', 22);
                $this->SetXY((107 + $i * 4.5) * 1.44, 80 * 1.37);
                $this->Cell(0, 0, $indx[$i]);
                $i++;
            }
        }
    }

    function PrintShopIndex($indx)
    {
        $this->SetFont('TimesNRCyrMT', '', 23);
        $indx = tocp1251($indx);
        if (isset($indx) and (mb_strlen($indx, 'windows-1251') >= 1)) {
            $i = 0;
            while ($i <= (mb_strlen($indx, 'windows-1251') - 1)) {
                $this->SetXY(6+(33.4 + $i * 4.5) * 1.44, 61.8 * 1.37 - 2);
                $this->Cell(0, 0, $indx[$i]);
                $i++;
            }
        }
    }

    function PrintShopName($name)
    {
        $this->SetFont('TimesNRCyrMT', '', 11);
        $name = tocp1251($name);
        $ans = multiStr($name, array(27));
        $this->SetXY(15+15 * 1.44, 39.3 * 1.37);
        $this->Cell(0, 0, $ans[0]);
        $this->SetXY(15+2 * 1.44, (46.0 - 1.9) * 1.37);
        $this->Cell(0, 0, $ans[1]);
    }

    function PrintClientName($name)
    {
        $this->SetFont('TimesNRCyrMT', '', 11);
        $name = tocp1251($name);
        $ans = multiStr($name, array(27));
        $this->SetXY(78 * 1.44, 60.8 * 1.37-2);
        $this->Cell(0, 0, $ans[0]);
        $this->SetXY(68.7 * 1.44, 67.2 * 1.37-3);
        $this->Cell(0, 0, $ans[1]);
    }

    function PrintShopAddr($address)
    {
        $this->SetFont('TimesNRCyrMT', '', 11);
        $address = tocp1251($address);
        $ans = multiStr($address, array(35, 38));
        $this->SetXY(10+15 * 1.44, (52.8 - 2.0) * 1.37 - 0.5);
        $this->Cell(0, 0, $ans[0]);
        $this->SetXY(2 * 1.44, (58.2 - 2.0) * 1.37 - 0.3);
        $this->Cell(0, 0, $ans[1]);
        $this->SetXY(2 * 1.44, (64.3 - 2.0) * 1.37);
        $this->Cell(0, 0, $ans[2]);
    }

    function PrintClientAddr($address)
    {
        $this->SetFont('TimesNRCyrMT', '', 11);
        $address = tocp1251($address);
        $ans = multiStr($address, array(35, 38));
        $this->SetXY(78 * 1.44, 73.4 * 1.37-5);
        $this->Cell(0, 0, $ans[0]);
        $this->SetXY(68 * 1.44 + 1, 79.4 * 1.37-5);
        $this->Cell(0, 0, $ans[1]);
        $this->SetXY(68 * 1.44 + 1, (73 + 12.4) * 1.37-5);
        $this->Cell(0, 0, $ans[2]);
    }

    function PrintSumObStr($sum)
    {
        $this->SetFont('TimesNRCyrMT', '', 17);
        $sumstr = tocp1251("(" . propis(floatval($sum), false) . ") руб.");
        $this->SetXY(66 * 1.44 - 1, 43.0 * 1.37);
        $this->Cell(0, 0, $sum);
        $l = strlen(strval($sum));
        $sumstr = multiStr($sumstr, array(60 - $l * 3));
        if (isset($sumstr[1])) {
            $this->SetFont('TimesNRCyrMT', '', 11);
            $this->SetXY((68 + $l * 2.1) * 1.44, 41.5 * 1.37 - 1.4);
            $this->Cell(0, 0, $sumstr[0]);
            $this->SetXY((68 + $l * 2.1) * 1.44, 44.3 * 1.37 - 0.9);
            $this->Cell(0, 0, $sumstr[1]);
        } else {
            $this->SetFont('TimesNRCyrMT', '', 12);
            $this->SetXY((68 + $l * 2.1) * 1.44, 42.9 * 1.37);
            $this->Cell(0, 0, $sumstr[0]);
        }
        $this->SetFont('TimesNRCyrMT', '', 11);
        $this->SetXY(33.8 * 1.44 +6.5, 42.5);
        $this->Cell(0, 0, 'X');
    }

    function PrintSumNalStr($sum)
    {
        $this->SetFont('TimesNRCyrMT', '', 17);
        $sumstr = tocp1251("(" . propis(floatval($sum), false) . ") руб.");
        $this->SetXY(66 * 1.44 - 1, 54.0 * 1.37);
        $this->Cell(0, 0, $sum);
        $l = strlen(strval($sum));
        $sumstr = multiStr($sumstr, array(60 - $l * 3));
        if (isset($sumstr[1])) {
            $this->SetFont('TimesNRCyrMT', '', 11);
            $this->SetXY((68 + $l * 2.1) * 1.44, 51.7 * 1.37 - 1.4);
            $this->Cell(0, 0, $sumstr[0]);
            $this->SetXY((68 + $l * 2.1) * 1.44, 55.3 * 1.37 - 0.9);
            $this->Cell(0, 0, $sumstr[1]);
        } else {
            $this->SetFont('TimesNRCyrMT', '', 12);
            $this->SetXY((68 + $l * 2.1) * 1.44, 53.3 * 1.37);
            $this->Cell(0, 0, $sumstr[0]);
        }
        $this->SetFont('TimesNRCyrMT', '', 12);
        $this->SetXY(72.8 * 1.44 +6.5, 42.5);
        $this->Cell(0, 0, 'X');
    }
}

class PDF_Blankcp71 extends FPDF
{
    function PrintPage($title)
    {
        $this->SetTitle($title);
        $this->AddFont('TimesNRCyrMT', '', 'timcyr.php');
        $this->AddPage('P');
        $this->Image(SAMPLES_PATH . 'blankcp71.jpg', 0, 0, 210, 148);
    }

    function PrintClientName($name, $is_fiz)
    {
        $down = 25;
        $this->SetFont('TimesNRCyrMT', '', 9);
        $name = tocp1251(($name));
        if ($is_fiz) {
            $this->SetXY(31, 11.4 + $down + 1);
        } else $this->SetXY(42, 16.4 + $down + 1);
        $this->Cell(0, 0, $name);
    }

    function PrintClientAddr($address)
    {
        $down = 25;
        $this->SetFont('TimesNRCyrMT', '', 9);
        $address = tocp1251($address);
        $street_end = strpos($address, ",");
        $street = substr($address, 0, $street_end);
        $address = substr($address, $street_end + 1);
        $city_end = strpos($address, ",");
        $city = substr($address, 0, $city_end);
        $address = substr($address, $city_end + 1);
        $this->SetXY(26.4, 22.0 + $down + 1);
        $this->Cell(0, 0, $street);
        $this->SetXY(61.4, 27.35 + $down + 0.5);
        $this->Cell(0, 0, $city);
        $this->SetXY(26.4, 32.85 + $down + 0.2);
        $this->Cell(0, 0, $address);
    }

    function PrintShopName($name, $is_fiz)
    {
        $this->SetFont('TimesNRCyrMT', '', 9);
        $name = tocp1251($name);
        if ($is_fiz) {
            $this->SetXY(29, 9.4 + 2);
        } else $this->SetXY(40, 14.4 + 2);
        $this->Cell(0, 0, $name);
    }

    function PrintClientPhone($name)
    {
        $this->SetFont('TimesNRCyrMT', '', 11);
        $this->SetXY(115, 57.8);
        $this->Cell(0, 0, $name);
    }

    function PrintShopIndex($indx)
    {
        $this->SetFont('TimesNRCyrMT', '', 12);
        $indx = tocp1251($indx);
        if (isset($indx) and (mb_strlen($indx, 'windows-1251') >= 1)) {
            $i = 0;
            while ($i <= (mb_strlen($indx, 'windows-1251') - 1)) {
                $this->SetXY(39.5 + $i * 2.23, 25.15 + 1.4);
                $this->Cell(0, 0, $indx[$i]);
                $i++;
            }
        }
    }

    function PrintShopAddr($address)
    {
        $this->SetFont('TimesNRCyrMT', '', 9);
        $address = tocp1251($address);
        $street_end = strpos($address, ",");
        $street = substr($address, 0, $street_end);
        $address = substr($address, $street_end + 1);
        $city_end = strpos($address, ",");
        $city = substr($address, 0, $city_end);
        $address = substr($address, $city_end + 1);
        $this->SetXY(26.4, 20.0 + 1.5);
        $this->Cell(0, 0, $street);
        $this->SetXY(63.4, 25.35 + 1.5);
        $this->Cell(0, 0, $city);
        $this->SetXY(26.4, 30.85 + 1.4);
        $this->Cell(0, 0, $address);
    }

    function PrintClientIndex($indx)
    {
        $this->SetFont('TimesNRCyrMT', '', 12);
        $indx = tocp1251($indx);
        if (isset($indx) and (mb_strlen($indx, 'windows-1251') >= 1)) {
            $i = 0;
            while ($i <= (mb_strlen($indx, 'windows-1251') - 1)) {
                $this->SetXY(39.5 + $i * 2.23, 25.15 + 27 + 0.8);
                $this->Cell(0, 0, $indx[$i]);
                $i++;
            }
        }
    }
}

class PDF_Blankfind extends FPDF
{
    function PrintPage($title)
    {
        $this->SetTitle($title);
        $this->AddFont('TimesNRCyrMT', '', 'timcyr.php');
        $this->AddPage('P');
        $this->Image(SAMPLES_PATH . 'blankfind.jpg', 2, 2, 205, 290);
    }

    function PrintClient($name, $address, $indx)
    {
        $this->SetFont('TimesNRCyrMT', '', 10);
        $name = tocp1251($name);
        $address = tocp1251($address);
        $ans = multiStr($name . "; " . $indx . ", " . $address, array(60));
        $this->SetXY(73, 163.6 + 8.5);
        $this->Cell(0, 0, $ans[0]);
        $this->SetXY(20, 168.0 + 8.0);
        $this->Cell(0, 0, $ans[1]);
    }

    function PrintShop($name, $address, $indx)
    {
        $this->SetFont('TimesNRCyrMT', '', 10);
        $name = tocp1251($name);
        $this->SetXY(94, 18.2);
        $this->Cell(0, 0, tocp1251("Начальнику ОПС"));
        $this->SetXY(90, 21.8);
        $this->Cell(0, 0, $name);
        $this->SetFont('TimesNRCyrMT', '', 10);
        $address = tocp1251($address);
        $ans = multiStr($address, array(43));
        $this->SetXY(110, 25.3);
        $this->Cell(0, 0, $ans[0]);
        $this->SetXY(85, 29.0);
        $this->Cell(0, 0, $ans[1]);
        $ans = multiStr($name . "; " . $indx . ", " . $address, array(60));
        $this->SetXY(79, 163.6);
        $this->Cell(0, 0, $ans[0]);
        $this->SetXY(20, 168.0);
        $this->Cell(0, 0, $ans[1]);
    }

    function PrintClientPhone($phone)
    {
        $this->SetFont('TimesNRCyrMT', '', 15);
        $phone = tocp1251($phone);
        if (isset($phone) and (mb_strlen($phone, 'windows-1251') >= 1)) {
            $i = 0;
            while ($i <= (mb_strlen($phone, 'windows-1251') - 1)) {
                $this->SetXY(160.3 + $i * 4.05, 72.7);
                $this->Cell(0, 0, $phone[$i]);
                $i++;
            }
        }
    }

    function PrintShopPhone($phone)
    {
        $this->SetFont('TimesNRCyrMT', '', 9);
        $phone = tocp1251($phone);
        if (isset($phone) and (mb_strlen($phone, 'windows-1251') >= 1)) {
            $i = 0;
            while ($i <= (mb_strlen($phone, 'windows-1251') - 1)) {
                $this->SetXY(94.3 + $i * 2.65, 32.6);
                $this->Cell(0, 0, $phone[$i]);
                $i++;
            }
        }
    }

    function PrintSumNal($sum)
    {
        $this->SetFont('TimesNRCyrMT', '', 13);
        $sum = tocp1251($sum);
        $this->SetXY(160, 108.5);
        $this->Cell(0, 0, $sum);
        $this->SetFont('TimesNRCyrMT', '', 19);
        $this->SetXY(89, 108.5);
        $this->Cell(0, 0, "X");
    }

    function PrintSumOb($sum)
    {
        $this->SetFont('TimesNRCyrMT', '', 13);
        $sum = tocp1251($sum);
        $this->SetXY(150, 108.5 + 33);
        $this->Cell(0, 0, $sum);
        $this->SetFont('TimesNRCyrMT', '', 19);
        $this->SetXY(85.5, 108.5 + 33);
        $this->Cell(0, 0, "X");
    }

    function PrintShopDocument($document, $ser, $nomer, $data, $org)
    {
        $this->SetFont('TimesNRCyrMT', '', 12);
        $document = tocp1251($document);
        $ser = tocp1251($ser);
        $nomer = tocp1251($nomer);
        $org = tocp1251($org);
        $data = tocp1251($data);
        $data = explode("-", $data);
        $this->SetXY(138, 39.3);
        $this->Cell(0, 0, $document);
        $this->SetFont('TimesNRCyrMT', '', 10);
        $this->SetXY(99, 43.3);
        $this->Cell(0, 0, $ser);
        $this->SetXY(155, 43.3);
        $this->Cell(0, 0, $nomer);
        $this->SetFont('TimesNRCyrMT', '', 10);
        $this->SetXY(96, 46.8);
        $s = $data[2] . "." . $data[1] . "." . $data[0] . " " . $org;
        $ans = multiStr($s, array(43));
        $this->Cell(0, 0, $ans[0]);
        $this->SetXY(126, 50.8);
        $this->Cell(0, 0, $ans[1]);
    }
}

class PDF_Blankcn23 extends FPDF
{
    function PrintPage($title)
    {
        $this->SetTitle($title);
        $this->AddFont('TimesNRCyrMT', '', 'timcyr.php');
        $this->AddPage('P');
        $this->Image(SAMPLES_PATH . 'blankcn23.jpg', 0, 0, 210, 148);
    }

    function PrintGoods($goods)
    {
        $this->SetFont('TimesNRCyrMT', '', 10);
        $i = 0;
        $num = 1;
        $over = 25;
        $step = 5.35;
        $startv = 72.0;
        $sum = 0;
        $cnt = 0;
        foreach ($goods as $good) {
            $cnt += $good['quantity'];
            $sum += ((int)$good['price']) * $good['quantity'];
            $name = tocp1251($good['name']);
            $this->SetXY(72.5, $startv + $step * ($i));
            $this->Cell(0, 0, $good['quantity'] . tocp1251(' шт.'));
            $this->SetXY(120 - 2, $startv + $step * ($i));
            $this->Cell(0, 0, ((int)$good['price']) . tocp1251(' руб.'));
            $this->SetXY(20 - 2, $startv + $step * ($i));
            $this->Cell(0, 0, $name);
            $i++;
        }
        $this->SetXY(120 - 2, $startv + $step * (4) + 2);
        $this->Cell(0, 0, $sum . tocp1251(' руб.'));
    }

    function PrintClientName($name, $is_fiz)
    {
        $down = 25;
        $this->SetFont('TimesNRCyrMT', '', 9);
        $name = tocp1251($name);
        if ($is_fiz) {
            $this->SetXY(31, 11.4 + $down);
        } else $this->SetXY(42, 16.4 + $down);
        $this->Cell(0, 0, $name);
    }

    function PrintClientAddr($address)
    {
        $down = 25;
        $this->SetFont('TimesNRCyrMT', '', 9);
        $address = tocp1251($address);
        $street_end = strpos($address, ",");
        $street = substr($address, 0, $street_end);
        $address = substr($address, $street_end + 1);
        $city_end = strpos($address, ",");
        $city = substr($address, 0, $city_end);
        $address = substr($address, $city_end + 1);
        $this->SetXY(26.4, 22.0 + $down);
        $this->Cell(0, 0, $street);
        $this->SetXY(64.4, 27.35 + $down);
        $this->Cell(0, 0, $city);
        $this->SetXY(26.4, 32.85 + $down);
        $this->Cell(0, 0, $address);
    }

    function PrintShopName($name, $is_fiz)
    {
        $this->SetFont('TimesNRCyrMT', '', 9);
        $name = tocp1251($name);
        if ($is_fiz) {
            $this->SetXY(29, 9.4);
        } else $this->SetXY(40, 14.4);
        $this->Cell(0, 0, $name);
    }

    function PrintClientPhone($name)
    {
        $this->SetFont('TimesNRCyrMT', '', 11);
        $this->SetXY(115, 57.8);
        $this->Cell(0, 0, $name);
    }

    function PrintShopIndex($indx)
    {
        $this->SetFont('TimesNRCyrMT', '', 12);
        $indx = tocp1251($indx);
        if (isset($indx) and (mb_strlen($indx, 'windows-1251') >= 1)) {
            $i = 0;
            while ($i <= (mb_strlen($indx, 'windows-1251') - 1)) {
                $this->SetXY(39.5 + $i * 2.23, 25.15);
                $this->Cell(0, 0, $indx[$i]);
                $i++;
            }
        }
    }

    function PrintShopAddr($address)
    {
        $this->SetFont('TimesNRCyrMT', '', 9);
        $address = tocp1251($address);
        $street_end = strpos($address, ",");
        $street = substr($address, 0, $street_end);
        $address = substr($address, $street_end + 1);
        $city_end = strpos($address, ",");
        $city = substr($address, 0, $city_end);
        $address = substr($address, $city_end + 1);
        $this->SetXY(26.4, 20.0);
        $this->Cell(0, 0, $street);
        $this->SetXY(64.4, 25.35);
        $this->Cell(0, 0, $city);
        $this->SetXY(26.4, 30.85);
        $this->Cell(0, 0, $address);
    }

    function PrintClientIndex($indx)
    {
        $this->SetFont('TimesNRCyrMT', '', 12);
        $indx = tocp1251($indx);
        if (isset($indx) and (mb_strlen($indx, 'windows-1251') >= 1)) {
            $i = 0;
            while ($i <= (mb_strlen($indx, 'windows-1251') - 1)) {
                $this->SetXY(39.5 + $i * 2.23, 25.15 + 27);
                $this->Cell(0, 0, $indx[$i]);
                $i++;
            }
        }
    }
}

class PDF_Blank112 extends FPDF
{
    function PrintPage($title)
    {
        $this->SetTitle($title);
        $this->AddFont('TimesNRCyrMT', '', 'timcyr.php');
        $this->AddPage('P');
        $this->Image(SAMPLES_PATH . 'blank112.jpg', 2, 2, 205, 290);
    }

    function PrintShopIndex($indx)
    {
        $this->SetFont('TimesNRCyrMT', '', 21);
        $indx = tocp1251($indx);
        if (isset($indx) and (mb_strlen($indx, 'windows-1251') >= 1)) {
            $i = 0;
            while ($i <= (mb_strlen($indx, 'windows-1251') - 1)) {
                $this->SetXY(170.6 + $i * 5.1, 93.0);
                $this->Cell(0, 0, $indx[$i]);
                $i++;
            }
        }
    }

    function PrintClientIndex($indx)
    {
        $this->SetFont('TimesNRCyrMT', '', 21);
        $indx = tocp1251($indx);
        if (isset($indx) and (mb_strlen($indx, 'windows-1251') >= 1)) {
            $i = 0;
            while ($i <= (mb_strlen($indx, 'windows-1251') - 1)) {
                $this->SetXY(170.6 + $i * 5.1, 151.3);
                $this->Cell(0, 0, $indx[$i]);
                $i++;
            }
        }
    }

    function PrintShopBankName($name)
    {
        $this->SetFont('TimesNRCyrMT', '', 15);
        $name = tocp1251($name);
        $this->SetXY(51, 125.5);
        $this->Cell(0, 0, $name);
    }

    function PrintShopBankKs($indx)
    {
        $this->SetFont('TimesNRCyrMT', '', 15);
        $indx = tocp1251($indx);
        if (isset($indx) and (mb_strlen($indx, 'windows-1251') >= 1)) {
            $i = 0;
            while ($i <= (mb_strlen($indx, 'windows-1251') - 1)) {
                $this->SetXY(105.4 + $i * 4.80, 119.3);
                $this->Cell(0, 0, $indx[$i]);
                $i++;
            }
        }
    }

    function PrintShopBankRs($indx)
    {
        $this->SetFont('TimesNRCyrMT', '', 15);
        $indx = tocp1251($indx);
        if (isset($indx) and (mb_strlen($indx, 'windows-1251') >= 1)) {
            $i = 0;
            while ($i <= (mb_strlen($indx, 'windows-1251') - 1)) {
                $this->SetXY(27.7 + $i * 4.8, 131.55);
                $this->Cell(0, 0, $indx[$i]);
                $i++;
            }
        }
    }

    function PrintShopBankBik($indx)
    {
        $indx = tocp1251($indx);
        if (isset($indx) and (mb_strlen($indx, 'windows-1251') >= 1)) {
            $i = 0;
            while ($i <= (mb_strlen($indx, 'windows-1251') - 1)) {
                $this->SetXY(158.0 + $i * 4.8, 131.6);
                $this->Cell(0, 0, $indx[$i]);
                $i++;
            }
        }
    }

    function PrintClientName($name)
    {
        $this->SetFont('TimesNRCyrMT', '', 15);
        $name = tocp1251($name);
        $this->SetXY(27, 137.7);
        $this->Cell(0, 0, $name);
    }

    function PrintShopName($name)
    {
        $this->SetFont('TimesNRCyrMT', '', 15);
        $name = tocp1251($name);
        $this->SetXY(20, 78.9);
        $this->Cell(0, 0, $name);
    }

    function PrintShopAddr($address)
    {
        $this->SetFont('TimesNRCyrMT', '', 13);
        $address = tocp1251($address);
        $ans = multiStr($address, array(83));
        $this->SetXY(20, 86.3);
        $this->Cell(0, 0, $ans[0]);
        $this->SetXY(13, 94.0);
        $this->Cell(0, 0, $ans[1]);
    }

    function PrintClientAddr($address)
    {
        $this->SetFont('TimesNRCyrMT', '', 13);
        $address = tocp1251($address);
        $ans = multiStr($address, array(68));
        $this->SetXY(49, 144.6);
        $this->Cell(0, 0, $ans[0]);
        $this->SetXY(10, 152.0);
        $this->Cell(0, 0, $ans[1]);
    }

    function PrintSumNal($val)
    {
        if ($val == '') return;
        $this->SetFont('TimesNRCyrMT', '', 13);
        $val = tocp1251($val);
        $val = floatval($val);
        $rub = floor($val) . '';
        $kop = round($val * 100 - floor($val) * 100);
        $kop = ($kop == 0 ? '00' : $kop . '');
        $this->SetXY(13, 62);
        $this->Cell(0, 0, $rub);
        $this->SetXY(37.5, 62);
        $this->Cell(0, 0, $kop);
        $this->SetFont('TimesNRCyrMT', '', 25);
        $this->SetXY(8.5, 71.0);
        $this->Cell(0, 0, 'X');
    }

    function PrintClientPhone($phone)
    {
        $this->SetFont('TimesNRCyrMT', '', 15);
        $phone = tocp1251($phone);
        if (isset($phone) and (mb_strlen($phone, 'windows-1251') >= 1)) {
            $i = 0;
            while ($i <= (mb_strlen($phone, 'windows-1251') - 1)) {
                $this->SetXY(160.3 + $i * 4.05, 72.7);
                $this->Cell(0, 0, $phone[$i]);
                $i++;
            }
        }
    }

    function PrintShopPhone($phone)
    {
        $this->SetFont('TimesNRCyrMT', '', 15);
        $phone = tocp1251($phone);
        if (isset($phone) and (mb_strlen($phone, 'windows-1251') >= 1)) {
            $i = 0;
            while ($i <= (mb_strlen($phone, 'windows-1251') - 1)) {
                $this->SetXY(160.3 + $i * 4.05, 66.4);
                $this->Cell(0, 0, $phone[$i]);
                $i++;
            }
        }
    }

    function PrintSumNalStr($sum)
    {
        $this->SetFont('TimesNRCyrMT', '', 13);
        $sum = tocp1251($sum);
        $this->SetXY(57, 57.5);
        $this->Cell(0, 0, $sum);
    }

    function PrintShopInn($inn)
    {
        $this->SetFont('TimesNRCyrMT', '', 15);
        $inn = tocp1251($inn);
        if (isset($inn) and (mb_strlen($inn, 'windows-1251') >= 1)) {
            $i = 0;
            while ($i <= (mb_strlen($inn, 'windows-1251') - 1)) {
                $this->SetXY(20.8 + $i * 4.76, 119.5);
                $this->Cell(0, 0, $inn[$i]);
                $i++;
            }
        }
    }
}

class PDF_Blank116 extends FPDF
{
    function PrintPage($title)
    {
        $this->SetTitle($title);
        $this->AddFont('TimesNRCyrMT', '', 'timcyr.php');
        $this->AddPage('P');
        $this->Image(SAMPLES_PATH . 'blank116.jpg', 2, 2, 205, 290);
    }

    function PrintPage2()
    {
        $this->AddPage('P');
        $this->Image(SAMPLES_PATH . 'blank116_2.jpg', 2, 2, 205, 290);
    }

    function PrintClientIndex($indx)
    {
        $this->SetFont('TimesNRCyrMT', '', 27);
        $indx = tocp1251($indx);
        if (isset($indx) and (mb_strlen($indx, 'windows-1251') >= 1)) {
            $i = 0;
            while ($i <= (mb_strlen($indx, 'windows-1251') - 1)) {
                $this->SetXY(97.0 + $i * 6.95, 116.3);
                $this->Cell(0, 0, $indx[$i]);
                $this->SetXY(147.4 + $i * 6.95, 267.5);
                $this->Cell(0, 0, $indx[$i]);
                $i++;
            }
        }
    }

    function PrintShopIndex($indx)
    {
        $this->SetFont('TimesNRCyrMT', '', 27);
        $indx = tocp1251($indx);
        if (isset($indx) and (mb_strlen($indx, 'windows-1251') >= 1)) {
            $i = 0;
            while ($i <= (mb_strlen($indx, 'windows-1251') - 1)) {
                $this->SetXY(148.0 + $i * 6.83, 144.15);
                $this->Cell(0, 0, $indx[$i]);
                $i++;
            }
        }
    }

    function PrintClientName($name)
    {
        $this->SetFont('TimesNRCyrMT', '', 15);
        $name = tocp1251($name);
        $this->SetXY(27, 92.4);
        $this->Cell(0, 0, $name);
        $this->SetXY(26, 247.0);
        $this->Cell(0, 0, $name);
    }

    function PrintShopName($name)
    {
        $this->SetFont('TimesNRCyrMT', '', 15);
        $name = tocp1251($name);
        $this->SetXY(32, 127.4);
        $this->Cell(0, 0, $name);
    }

    function PrintShopAddr($address)
    {
        $this->SetFont('TimesNRCyrMT', '', 15);
        $address = tocp1251($address);
        $ans = multiStr($address, array(60));
        $this->SetXY(28, 137.0);
        $this->Cell(0, 0, $ans[0]);
        $this->SetXY(13, 145.0);
        $this->Cell(0, 0, $ans[1]);
    }

    function PrintClientAddr($address)
    {
        $this->SetFont('TimesNRCyrMT', '', 15);
        $address = tocp1251($address);
        $ans = multiStr($address, array(41, 47));
        $this->SetXY(27.5, 99.4);
        $this->Cell(0, 0, $ans[0]);
        $this->SetXY(14, 99.4 + 9);
        $this->Cell(0, 0, $ans[1]);
        $this->SetXY(14, 99.4 + 18);
        $this->Cell(0, 0, $ans[2]);
        $ans = multiStr($address, array(60));
        $this->SetXY(28, 258);
        $this->Cell(0, 0, $ans[0]);
        $this->SetXY(14, 269);
        $this->Cell(0, 0, $ans[1]);
    }

    function PrintSumOb($val)
    {
        if ($val == '') return;
        $this->SetFont('TimesNRCyrMT', '', 13);
        $val = tocp1251($val);
        $val = floatval($val);
        $rub = floor($val) . '';
        $kop = round($val * 100 - floor($val) * 100);
        $kop = ($kop == 0 ? '00' : $kop . '');
        $this->SetXY(55, 236.5);
        $this->Cell(0, 0, $rub);
    }

    function PrintSumNal($val)
    {
        if ($val == '') return;
        $this->SetFont('TimesNRCyrMT', '', 13);
        $val = tocp1251($val);
        $val = floatval($val);
        $rub = floor($val) . '';
        $kop = round($val * 100 - floor($val) * 100);
        $kop = ($kop == 0 ? '00' : $kop . '');
        $this->SetXY(150, 236);
        $this->Cell(0, 0, $rub);
    }

    function PrintShopPhone($phone)
    {
        $this->SetFont('TimesNRCyrMT', '', 13);
        $phone = tocp1251($phone);
        if (isset($phone) and (mb_strlen($phone, 'windows-1251') >= 1)) {
            $i = 0;
            while ($i <= (mb_strlen($phone, 'windows-1251') - 1)) {
                $this->SetXY(160.6 + $i * 4.05, 72.7);
                $this->Cell(0, 0, $phone[$i]);
                $i++;
            }
        }
    }

    function PrintClientPhone($phone)
    {
        $this->SetFont('TimesNRCyrMT', '', 13);
        $phone = tocp1251($phone);
        if (isset($phone) and (mb_strlen($phone, 'windows-1251') >= 1)) {
            $i = 0;
            while ($i <= (mb_strlen($phone, 'windows-1251') - 1)) {
                $this->SetXY(160.6 + $i * 4.05, 66.4);
                $this->Cell(0, 0, $phone[$i]);
                $i++;
            }
        }
    }

    function PrintSumObStr($sum)
    {
        $this->SetFont('TimesNRCyrMT', '', 13);
        $sum = tocp1251($sum . " (" . propis(floatval($sum), false) . ") руб.");
        $this->SetXY(15, 71.0);
        $this->Cell(0, 0, $sum);
    }

    function PrintSumNalStr($sum)
    {
        $this->SetFont('TimesNRCyrMT', '', 13);
        $sum = tocp1251($sum . " (" . propis(floatval($sum), false) . ") руб.");
        $this->SetXY(15, 82.4);
        $this->Cell(0, 0, $sum);
    }

    function PrintShopDocument($document, $ser, $nomer, $data, $org)
    {
        $this->SetFont('TimesNRCyrMT', '', 15);
        $document = tocp1251($document);
        $ser = tocp1251($ser);
        $nomer = tocp1251($nomer);
        $org = tocp1251($org);
        $data = tocp1251($data);
        $data = explode("-", $data);
        $this->SetXY(38, 163.5);
        $this->Cell(0, 0, $document);
        $this->SetFont('TimesNRCyrMT', '', 17);
        $this->SetXY(83, 163.5);
        $this->Cell(0, 0, $ser);
        $this->SetXY(108, 163.5);
        $this->Cell(0, 0, $nomer);
        $this->SetFont('TimesNRCyrMT', '', 15);
        $this->SetXY(146, 163.5);
        $this->Cell(0, 0, $data[2] . "." . $data[1]);
        $this->SetXY(178, 163.5);
        $this->Cell(0, 0, substr($data[0], -2));
        $this->SetFont('TimesNRCyrMT', '', 13);
        $this->SetXY(18, 171.3);
        $this->Cell(0, 0, $org);
    }
}

class PDF_Blank112116 extends FPDF
{
    function PrintPage($title)
    {
        $this->SetTitle($title);
        $this->AddFont('TimesNRCyrMT', '', 'timcyr.php');
        $this->AddPage('L');
        $this->Image(SAMPLES_PATH . 'blank116.jpg', 0, 1, 145, 206);
        $this->Image(SAMPLES_PATH . 'blank112.jpg', 151, 1, 145, 206);
    }

    function PrintClientIndex($indx)
    {
        $v = 0.71345;
        $h = 0.6868;
        $indx = tocp1251($indx);
        if (isset($indx) and (mb_strlen($indx, 'windows-1251') >= 1)) {
            $i = 0;
            while ($i <= (mb_strlen($indx, 'windows-1251') - 1)) {
                $this->SetFont('TimesNRCyrMT', '', 20);
                $this->SetXY(97.3 * $h + $i * 4.95, 114.9 * $v);
                $this->Cell(0, 0, $indx[$i]);
                $this->SetXY(149.4 * $h + $i * 4.80, 189.5);
                $this->Cell(0, 0, $indx[$i]);
                $this->SetFont('TimesNRCyrMT', '', 16);
                $this->SetXY(269.9 + $i * 3.55, 107.2);
                $this->Cell(0, 0, $indx[$i]);
                $i++;
            }
        }
    }

    function PrintShopIndex($indx)
    {
        $v = 0.71345;
        $h = 0.6168;
        $indx = tocp1251($indx);
        if (isset($indx) and (mb_strlen($indx, 'windows-1251') >= 1)) {
            $i = 0;
            while ($i <= (mb_strlen($indx, 'windows-1251') - 1)) {
                $this->SetFont('TimesNRCyrMT', '', 19);
                $this->SetXY(102.6 + $i * 4.95, 101.8);
                $this->Cell(0, 0, $indx[$i]);
                $this->SetFont('TimesNRCyrMT', '', 16);
                $this->SetXY(269.9 + $i * 3.55, 65.4);
                $this->Cell(0, 0, $indx[$i]);
                $i++;
            }
        }
    }

    function PrintClientName($name)
    {
        $this->SetFont('TimesNRCyrMT', '', 11);
        $name = tocp1251($name);
        $v = 0.70245;
        $h = 0.6168;
        $this->SetXY(27 * $h, 92.4 * $v);
        $this->Cell(0, 0, $name);
        $this->SetXY(26 * $h, 248.9 * $v);
        $this->Cell(0, 0, $name);
        $this->SetXY(167, 97.3);
        $this->Cell(0, 0, $name);
    }

    function PrintShopName($name)
    {
        $v = 0.70245;
        $h = 0.6168;
        $this->SetFont('TimesNRCyrMT', '', 11);
        $name = tocp1251($name);
        $this->SetXY(32 * $h, 127.8 * $v);
        $this->Cell(0, 0, $name);
        $this->SetXY(163, 55.7);
        $this->Cell(0, 0, $name);
    }

    function PrintShopAddr($address)
    {
        $this->SetFont('TimesNRCyrMT', '', 11);
        $address = tocp1251($address);
        $ans = multiStr($address, array(60));
        $this->SetXY(18, 96.5);
        $this->Cell(0, 0, $ans[0]);
        $this->SetXY(10, 102.0);
        $this->Cell(0, 0, $ans[1]);
        $ans = multiStr($address, array(70));
        $this->SetXY(163, 60.6);
        $this->Cell(0, 0, $ans[0]);
        $this->SetXY(155, 65.5);
        $this->Cell(0, 0, $ans[1]);
    }

    function PrintClientAddr($address)
    {
        $this->SetFont('TimesNRCyrMT', '', 11);
        $address = tocp1251($address);
        $ans = multiStr($address, array(41, 47));
        $this->SetXY(18.5, 70.1);
        $this->Cell(0, 0, $ans[0]);
        $this->SetXY(9, 70.1 + 6);
        $this->Cell(0, 0, $ans[1]);
        $this->SetXY(9, 70.1 + 13);
        $this->Cell(0, 0, $ans[2]);
        $ans = multiStr($address, array(60));
        $this->SetXY(18, 182.5);
        $this->Cell(0, 0, $ans[0]);
        $this->SetXY(10, 189.9);
        $this->Cell(0, 0, $ans[1]);
        $this->SetXY(184, 102.5);
        $this->Cell(0, 0, $ans[0]);
        $this->SetXY(155, 107.4);
        $this->Cell(0, 0, $ans[1]);
    }

    function PrintShopPhone($phone)
    {
        $this->SetFont('TimesNRCyrMT', '', 13);
        $phone = tocp1251($phone);
        if (isset($phone) and (mb_strlen($phone, 'windows-1251') >= 1)) {
            $i = 0;
            while ($i <= (mb_strlen($phone, 'windows-1251') - 1)) {
                $this->SetXY(262.7 + $i * 2.86, 46.7);
                $this->Cell(0, 0, $phone[$i]);
                $i++;
            }
        }
    }

    function PrintClientPhone($phone)
    {
        $this->SetFont('TimesNRCyrMT', '', 13);
        $phone = tocp1251($phone);
        if (isset($phone) and (mb_strlen($phone, 'windows-1251') >= 1)) {
            $i = 0;
            while ($i <= (mb_strlen($phone, 'windows-1251') - 1)) {
                $this->SetXY(262.7 + $i * 2.86, 51.2);
                $this->Cell(0, 0, $phone[$i]);
                $i++;
            }
        }
    }

    function PrintSumObStr($sum)
    {
        $this->SetFont('TimesNRCyrMT', '', 13);
        $this->SetXY(36, 166.8);
        $this->Cell(0, 0, $sum);
        $sumstr = tocp1251("(" . propis(floatval($sum), false) . ") руб.");
        $this->SetXY(8.5, 50.0);
        $this->Cell(0, 0, $sum);
        $l = strlen(strval($sum));
        $sumstr = multiStr($sumstr, array(60 - $l * 3));
        if (isset($sumstr[1])) {
            $this->SetFont('TimesNRCyrMT', '', 9);
            $this->SetXY(8 + $l * 2.7, 48.3);
            $this->Cell(0, 0, $sumstr[0]);
            $this->SetXY(8 + $l * 2.7, 51.1);
            $this->Cell(0, 0, $sumstr[1]);
        } else {
            $this->SetFont('TimesNRCyrMT', '', 10);
            $this->SetXY(8 + $l * 2.7, 50.0);
            $this->Cell(0, 0, $sumstr[0]);
        }
    }

    function PrintSumNalStr($sum)
    {
        $this->SetFont('TimesNRCyrMT', '', 13);
        $this->SetXY(104, 166.8);
        $this->Cell(0, 0, $sum);
        $this->SetXY(156.8, 43.4);
        $this->Cell(0, 0, $sum);
        $this->SetXY(175.8, 43.4);
        $this->Cell(0, 0, "00");
        $sumstr = tocp1251("(" . propis(floatval($sum), false) . ") руб.");
        $this->SetXY(8.5, 58.5);
        $this->Cell(0, 0, $sum);
        $l = strlen(strval($sum));
        $sumstr = multiStr($sumstr, array(60 - $l * 3));
        if (isset($sumstr[1])) {
            $this->SetFont('TimesNRCyrMT', '', 9);
            $this->SetXY(8 + $l * 2.7, 56.8);
            $this->Cell(0, 0, $sumstr[0]);
            $this->SetXY(8 + $l * 2.7, 59.6);
            $this->Cell(0, 0, $sumstr[1]);
        } else {
            $this->SetFont('TimesNRCyrMT', '', 10);
            $this->SetXY(8 + $l * 2.7, 58.5);
            $this->Cell(0, 0, $sumstr[0]);
        }
        $this->SetFont('TimesNRCyrMT', '', 18);
        $this->SetXY(155, 49.9);
        $this->Cell(0, 0, "X");
        $this->SetFont('TimesNRCyrMT', '', 11);
        $sumstr = tocp1251(propis(floatval($sum), true));
        $this->SetXY(189.8, 39.9);
        $this->Cell(0, 0, $sumstr);
    }

    function PrintShopDocument($document, $ser, $nomer, $data, $org)
    {
        $this->SetFont('TimesNRCyrMT', '', 11);
        $document = tocp1251($document);
        $ser = tocp1251($ser);
        $nomer = tocp1251($nomer);
        $org = tocp1251($org);
        $data = tocp1251($data);
        $data = explode("-", $data);
        $this->SetXY(26, 115.5);
        $this->Cell(0, 0, $document);
        $this->SetFont('TimesNRCyrMT', '', 13);
        $this->SetXY(56, 115.5);
        $this->Cell(0, 0, $ser);
        $this->SetXY(74, 115.5);
        $this->Cell(0, 0, $nomer);
        $this->SetFont('TimesNRCyrMT', '', 11);
        $this->SetXY(102, 115.5);
        $this->Cell(0, 0, $data[2] . "." . $data[1]);
        $this->SetXY(124.5, 115.5);
        $this->Cell(0, 0, substr($data[0], -2));
        $this->SetFont('TimesNRCyrMT', '', 11);
        $this->SetXY(10, 121.3);
        $this->Cell(0, 0, $org);
    }

    function PrintShopInn($inn)
    {
        $this->SetFont('TimesNRCyrMT', '', 12);
        $inn = tocp1251($inn);
        if (isset($inn) and (mb_strlen($inn, 'windows-1251') >= 1)) {
            $i = 0;
            while ($i <= (mb_strlen($inn, 'windows-1251') - 1)) {
                $this->SetXY(163.5 + $i * 3.41, 83.9);
                $this->Cell(0, 0, $inn[$i]);
                $i++;
            }
        }
    }

    function PrintShopBankKs($indx)
    {
        $this->SetFont('TimesNRCyrMT', '', 12);
        $indx = tocp1251($indx);
        if (isset($indx) and (mb_strlen($indx, 'windows-1251') >= 1)) {
            $i = 0;
            while ($i <= (mb_strlen($indx, 'windows-1251') - 1)) {
                $this->SetXY(223.9 + $i * 3.39, 83.9);
                $this->Cell(0, 0, $indx[$i]);
                $i++;
            }
        }
    }

    function PrintShopBankRs($indx)
    {
        $this->SetFont('TimesNRCyrMT', '', 12);
        $indx = tocp1251($indx);
        if (isset($indx) and (mb_strlen($indx, 'windows-1251') >= 1)) {
            $i = 0;
            while ($i <= (mb_strlen($indx, 'windows-1251') - 1)) {
                $this->SetXY(168.5 + $i * 3.40, 92.85);
                $this->Cell(0, 0, $indx[$i]);
                $i++;
            }
        }
    }

    function PrintShopBankBik($indx)
    {
        $this->SetFont('TimesNRCyrMT', '', 12);
        $indx = tocp1251($indx);
        if (isset($indx) and (mb_strlen($indx, 'windows-1251') >= 1)) {
            $i = 0;
            while ($i <= (mb_strlen($indx, 'windows-1251') - 1)) {
                $this->SetXY(261.3 + $i * 3.380, 92.85);
                $this->Cell(0, 0, $indx[$i]);
                $i++;
            }
        }
    }

    function PrintShopBankName($name)
    {
        $this->SetFont('TimesNRCyrMT', '', 11);
        $name = tocp1251($name);
        $this->SetXY(186, 88.4);
        $this->Cell(0, 0, $name);
    }
}

class PDF_Opis107 extends FPDF
{
    function PrintPage($title)
    {
        $this->SetTitle($title);
        $this->AddFont('TimesNRCyrMT', '', 'timcyr.php');
        $this->AddPage('L');
        $this->Image(SAMPLES_PATH . 'opis107.jpg', -2, 2, 146, 208);
        $this->Image(SAMPLES_PATH . 'opis107.jpg', 148, 2, 146, 208);
    }

    function PrintGoods($cname, $indx, $addr, $goods, $itogo)
    {
        $itogo = ((int)$itogo);
        $itog_goods = 0;
        foreach ($goods as $good) {
            $itog_goods += ((int)$good['price']) * $good['quantity'];
        }
        for ($i = 0; $i < (count($goods) - 1); $i++) {
            $goods[$i]['price'] = round($itogo / $itog_goods * ((int)$goods[$i]['price']));
        }
        $itog_goods = 0;
        foreach ($goods as $good) {
            $itog_goods += ((int)$good['price']) * $good['quantity'];
        }
        if ($itog_goods < $itogo) $goods[0]['price'] += (int)round($itogo - $itog_goods);
        $this->SetFont('TimesNRCyrMT', '', 14);
        $i = 0;
        $num = 1;
        $over = 29;
        $step = 5.0;
        $startv = 89.6;
        $r = 150;
        $sum = 0;
        $cnt = 0;
        $cname = tocp1251($cname);
        $address = tocp1251($indx . ', ' . $addr);
        $ad = multiStr($address, array(48));
        $this->SetXY(23, 57.0);
        $this->Cell(0, 0, $cname);
        $this->SetXY(23 + $r, 57.0);
        $this->Cell(0, 0, $cname);
        $this->SetXY(23, 63.7);
        $this->Cell(0, 0, $ad[0]);
        $this->SetXY(8, 71.2);
        $this->Cell(0, 0, $ad[1]);
        $this->SetXY(23 + $r, 63.7);
        $this->Cell(0, 0, $ad[0]);
        $this->SetXY(8 + $r, 71.2);
        $this->Cell(0, 0, $ad[1]);
        foreach ($goods as $good) {
            $cnt += $good['quantity'];
            $sum += ((int)round($good['price'])) * $good['quantity'];
            $name = tocp1251($good['name']);
            $stl = strlen($name);
            if (((14 - $i) * $over) < $stl) {
                $this->SetFont('TimesNRCyrMT', '', 14);
                $this->AddPage('L');
                $this->Image(SAMPLES_PATH . 'opis107.jpg', -2, 2, 146, 208);
                $this->Image(SAMPLES_PATH . 'opis107.jpg', 148, 2, 146, 208);
                $this->SetXY(23, 57.0);
                $this->Cell(0, 0, $cname);
                $this->SetXY(23 + $r, 57.0);
                $this->Cell(0, 0, $cname);
                $this->SetXY(23, 63.7);
                $this->Cell(0, 0, $ad[0]);
                $this->SetXY(8, 71.2);
                $this->Cell(0, 0, $ad[1]);
                $this->SetXY(23 + $r, 63.7);
                $this->Cell(0, 0, $ad[0]);
                $this->SetXY(8 + $r, 71.2);
                $this->Cell(0, 0, $ad[1]);
                $i = 0;
            }
            $this->SetFont('TimesNRCyrMT', '', 11);
            $this->SetXY(12, $startv + $step * ($i));
            $this->Cell(0, 0, $num);
            $this->SetXY(12 + $r, $startv + $step * ($i));
            $this->Cell(0, 0, $num++);
            while (strlen($name) > $over) {
                $ans = multiStr($name, array($over));
                $this->SetXY(20, $startv + $step * $i);
                $this->Cell(0, 0, $ans[0]);
                $this->SetXY(20 + $r, $startv + $step * $i);
                $this->Cell(0, 0, $ans[0]);
                $i++;
                $name = $ans[1];
            }
            $this->SetXY(85.5 + $r, $startv + $step * ($i));
            $this->Cell(0, 0, $good['quantity']);
            $this->SetXY(112 + $r, $startv + $step * ($i));
            $this->Cell(0, 0, (int)round($good['price'] * intval($good['quantity'])));
            $this->SetXY(20 + $r, $startv + $step * ($i));
            $this->Cell(0, 0, $name);
            $this->SetXY(85.5, $startv + $step * ($i));
            $this->Cell(0, 0, $good['quantity']);
            $this->SetXY(112, $startv + $step * ($i));
            $this->Cell(0, 0, (int)round($good['price'] * intval($good['quantity'])));
            $this->SetXY(20, $startv + $step * ($i));
            $this->Cell(0, 0, $name);
            $i++;
        }
        $this->SetXY(58, 162.0);
        $this->Cell(0, 0, $cnt . tocp1251(' предм., ') . " " . $sum . tocp1251(' руб.'));
        $this->SetXY(58 + $r, 162);
        $this->Cell(0, 0, $cnt . tocp1251(' предм., ') . " " . $sum . tocp1251(' руб.'));
    }

    function PrintClientName($name)
    {
        $this->SetFont('TimesNRCyrMT', '', 15);
        $name = tocp1251($name);
        $this->SetXY(37, 79.4);
        $this->Cell(0, 0, $name);
    }

    function PrintClientAddr($indx, $address)
    {
        $this->SetFont('TimesNRCyrMT', '', 15);
        $address = tocp1251($indx . ', ' . $address);
        $ans = multiStr($address, array(61));
        $this->SetXY(37, 89.4);
        $this->Cell(0, 0, $ans[0]);
        $this->SetXY(24, 99.4);
        $this->Cell(0, 0, $ans[1]);
    }
}

class PDF_Blank7a extends FPDF
{
    function PrintPage($title)
    {
        $this->SetTitle($title);
        $this->AddFont('Pechkin', '', '400a3fdb79b131fc51c59e3bc235f2d6_index.php');
        $this->AddFont('TimesNRCyrMT', '', 'timcyr.php');
        $this->AddPage('L');
        $this->Image(SAMPLES_PATH . 'blank7a.jpg', 1, 1, 145, 105);
    }

    function PrintClientIndex($indx)
    {
        $this->SetFont('TimesNRCyrMT', '', 42);
        $indx = tocp1251($indx);
        if (isset($indx) and (mb_strlen($indx, 'windows-1251') >= 1)) {
            $i = 0;
            while ($i <= (mb_strlen($indx, 'windows-1251') - 1)) {
                $this->SetFont('Pechkin', '', 35);
                $this->SetXY(10.34 + $i * 8.75, 97.70);
                $this->Cell(0, 0, $indx[$i]);
                $this->SetFont('TimesNRCyrMT', '', 20);
                $this->SetXY(111.0 + $i * 5.0, 84.6);
                $this->Cell(0, 0, $indx[$i]);
                $i++;
            }
        }
    }

    function PrintShopIndex($indx)
    {
        $this->SetFont('TimesNRCyrMT', '', 20);
        $indx = tocp1251($indx);
        if (isset($indx) and (mb_strlen($indx, 'windows-1251') >= 1)) {
            $i = 0;
            while ($i <= (mb_strlen($indx, 'windows-1251') - 1)) {
                $this->SetXY(32.5 + $i * 4.9, 70.0);
                $this->Cell(0, 0, $indx[$i]);
                $i++;
            }
        }
    }

    function PrintShopName($name)
    {
        $this->SetFont('TimesNRCyrMT', '', 12);
        $name = tocp1251($name);
        $ans = multiStr($name, array(20));
        $this->SetXY(15, 40.0);
        $this->Cell(0, 0, $ans[0]);
        $this->SetXY(2, 46.0);
        $this->Cell(0, 0, $ans[1]);
    }

    function PrintClientName($name)
    {
        $this->SetFont('TimesNRCyrMT', '', 12);
        $name = tocp1251($name);
        $ans = multiStr($name, array(20));
        $this->SetXY(78, 61.0);
        $this->Cell(0, 0, $ans[0]);
        $this->SetXY(68, 66.0);
        $this->Cell(0, 0, $ans[1]);
    }

    function PrintShopAddr($address)
    {
        $this->SetFont('TimesNRCyrMT', '', 11);
        $address = tocp1251($address);
        $ans = multiStr($address, array(28, 36));
        $this->SetXY(15, 52.8);
        $this->Cell(0, 0, $ans[0]);
        $this->SetXY(2, 58.2);
        $this->Cell(0, 0, $ans[1]);
        $this->SetXY(2, 64.3);
        $this->Cell(0, 0, $ans[2]);
    }

    function PrintClientAddr($address)
    {
        $this->SetFont('TimesNRCyrMT', '', 11);
        $address = tocp1251($address);
        $ans = multiStr($address, array(28, 36));
        $this->SetXY(78, 73.0);
        $this->Cell(0, 0, $ans[0]);
        $this->SetXY(67, 73 + 6.0);
        $this->Cell(0, 0, $ans[1]);
        $this->SetXY(67, 73 + 12.0);
        $this->Cell(0, 0, $ans[2]);
    }

    function PrintSumObStr($sum)
    {
        $this->SetFont('TimesNRCyrMT', '', 17);
        $sumstr = tocp1251("(" . propis(floatval($sum), false) . ") руб.");
        $this->SetXY(66, 42.0);
        $this->Cell(0, 0, $sum);
        $l = strlen(strval($sum));
        $sumstr = multiStr($sumstr, array(50 - $l * 3));
        if (isset($sumstr[1])) {
            $this->SetFont('TimesNRCyrMT', '', 9);
            $this->SetXY(68 + $l * 2.7, 39.5);
            $this->Cell(0, 0, $sumstr[0]);
            $this->SetXY(68 + $l * 2.7, 39.5 + 3.1);
            $this->Cell(0, 0, $sumstr[1]);
        } else {
            $this->SetFont('TimesNRCyrMT', '', 10);
            $this->SetXY(68 + $l * 2.7, 41.5);
            $this->Cell(0, 0, $sumstr[0]);
        }
        $this->SetFont('TimesNRCyrMT', '', 10);
        $this->SetXY(55.8, 18.6);
        $this->Cell(0, 0, 'X');
    }

    function PrintSumNalStr($sum)
    {
        $this->SetFont('TimesNRCyrMT', '', 17);
        $sumstr = tocp1251("(" . propis(floatval($sum), false) . ") руб.");
        $this->SetXY(66, 52.3);
        $this->Cell(0, 0, $sum);
        $l = strlen(strval($sum));
        $sumstr = multiStr($sumstr, array(50 - $l * 3));
        if (isset($sumstr[1])) {
            $this->SetFont('TimesNRCyrMT', '', 9);
            $this->SetXY(68 + $l * 2.7, 50.3);
            $this->Cell(0, 0, $sumstr[0]);
            $this->SetXY(68 + $l * 2.7, 50.3 + 3.1);
            $this->Cell(0, 0, $sumstr[1]);
        } else {
            $this->SetFont('TimesNRCyrMT', '', 10);
            $this->SetXY(68 + $l * 2.7, 51.8);
            $this->Cell(0, 0, $sumstr[0]);
        }
        $this->SetFont('TimesNRCyrMT', '', 10);
        $this->SetXY(81.8, 5.9);
        $this->Cell(0, 0, 'X');
    }
}

class PDF_Blank7b extends FPDF
{
    function PrintPage($title)
    {
        $this->SetTitle($title);
        $this->AddFont('Pechkin', '', '400a3fdb79b131fc51c59e3bc235f2d6_index.php');
        $this->AddFont('TimesNRCyrMT', '', 'timcyr.php');
        $this->AddPage('L');
        $this->Image(SAMPLES_PATH . 'blank7b.jpg', 1, 1, 145, 105);
    }

    function PrintClientIndex($indx)
    {
        $this->SetFont('TimesNRCyrMT', '', 42);
        $indx = tocp1251($indx);
        if (isset($indx) and (mb_strlen($indx, 'windows-1251') >= 1)) {
            $i = 0;
            while ($i <= (mb_strlen($indx, 'windows-1251') - 1)) {
                $this->SetFont('Pechkin', '', 35);
                $this->SetXY(10.54 + $i * 8.75, 97.25);
                $this->Cell(0, 0, $indx[$i]);
                $this->SetFont('TimesNRCyrMT', '', 20);
                $this->SetXY(111.0 + $i * 5.0, 84.6 - 5.4);
                $this->Cell(0, 0, $indx[$i]);
                $i++;
            }
        }
    }

    function PrintShopIndex($indx)
    {
        $this->SetFont('TimesNRCyrMT', '', 20);
        $indx = tocp1251($indx);
        if (isset($indx) and (mb_strlen($indx, 'windows-1251') >= 1)) {
            $i = 0;
            while ($i <= (mb_strlen($indx, 'windows-1251') - 1)) {
                $this->SetXY(32.5 + $i * 4.9, 70.0 - 8.5);
                $this->Cell(0, 0, $indx[$i]);
                $i++;
            }
        }
    }

    function PrintShopName($name)
    {
        $this->SetFont('TimesNRCyrMT', '', 12);
        $name = tocp1251($name);
        $ans = multiStr($name, array(20));
        $this->SetXY(15, 40.0 - 8.5);
        $this->Cell(0, 0, $ans[0]);
        $this->SetXY(2, 46.0 - 8.5);
        $this->Cell(0, 0, $ans[1]);
    }

    function PrintClientName($name)
    {
        $this->SetFont('TimesNRCyrMT', '', 12);
        $name = tocp1251($name);
        $ans = multiStr($name, array(20));
        $this->SetXY(78, 61.0 - 6.5);
        $this->Cell(0, 0, $ans[0]);
        $this->SetXY(68, 66.0 - 5.2);
        $this->Cell(0, 0, $ans[1]);
    }

    function PrintShopAddr($address)
    {
        $this->SetFont('TimesNRCyrMT', '', 11);
        $address = tocp1251($address);
        $ans = multiStr($address, array(28, 36));
        $this->SetXY(15, 52.8 - 8.7);
        $this->Cell(0, 0, $ans[0]);
        $this->SetXY(2, 58.2 - 8.5);
        $this->Cell(0, 0, $ans[1]);
        $this->SetXY(2, 64.3 - 8.5);
        $this->Cell(0, 0, $ans[2]);
    }

    function PrintClientAddr($address)
    {
        $this->SetFont('TimesNRCyrMT', '', 11);
        $address = tocp1251($address);
        $ans = multiStr($address, array(28, 36));
        $this->SetXY(78, 73.0 - 5.2);
        $this->Cell(0, 0, $ans[0]);
        $this->SetXY(67, 73 + 6.0 - 5.2);
        $this->Cell(0, 0, $ans[1]);
        $this->SetXY(67, 73 + 12.0 - 5.2);
        $this->Cell(0, 0, $ans[2]);
    }

    function PrintSumObStr($sum, $obnal)
    {
        $this->SetFont('TimesNRCyrMT', '', 17);
        $sumstr = tocp1251("(" . propis(floatval($sum), false) . ") руб.");
        $this->SetXY(66, 37.0);
        $this->Cell(0, 0, $sum);
        $l = strlen(strval($sum));
        $sumstr = multiStr($sumstr, array(50 - $l * 3));
        if (isset($sumstr[1])) {
            $this->SetFont('TimesNRCyrMT', '', 9);
            $this->SetXY(68 + $l * 2.7, 34.8);
            $this->Cell(0, 0, $sumstr[0]);
            $this->SetXY(68 + $l * 2.7, 37.9);
            $this->Cell(0, 0, $sumstr[1]);
        } else {
            $this->SetFont('TimesNRCyrMT', '', 10);
            $this->SetXY(68 + $l * 2.7, 36.6);
            $this->Cell(0, 0, $sumstr[0]);
        }
        if (!$obnal) {
            $this->SetFont('TimesNRCyrMT', '', 7);
            $this->SetXY(79.0, 11.5);
            $this->Cell(0, 0, 'X');
        }
    }

    function PrintSumNalStr($sum, $obnal)
    {
        $this->SetFont('TimesNRCyrMT', '', 17);
        $sumstr = tocp1251("(" . propis(floatval($sum), false) . ") руб.");
        $this->SetXY(66, 47.0);
        $this->Cell(0, 0, $sum);
        $l = strlen(strval($sum));
        $sumstr = multiStr($sumstr, array(50 - $l * 3));
        if (isset($sumstr[1])) {
            $this->SetFont('TimesNRCyrMT', '', 9);
            $this->SetXY(68 + $l * 2.7, 44.7);
            $this->Cell(0, 0, $sumstr[0]);
            $this->SetXY(68 + $l * 2.7, 47.5);
            $this->Cell(0, 0, $sumstr[1]);
        } else {
            $this->SetFont('TimesNRCyrMT', '', 10);
            $this->SetXY(68 + $l * 2.7, 46.9);
            $this->Cell(0, 0, $sumstr[0]);
        }
        if ($obnal) {
            $this->SetFont('TimesNRCyrMT', '', 7);
            $this->SetXY(79.0, 16.8);
            $this->Cell(0, 0, 'X');
        }
    }
}

class PDF_Blank7p extends FPDF
{
    function PrintPage($title)
    {
        $this->SetTitle($title);
        $this->AddFont('Pechkin', '', '400a3fdb79b131fc51c59e3bc235f2d6_index.php');
        $this->AddFont('TimesNRCyrMT', '', 'timcyr.php');
        $this->AddPage('L');
        $this->Image(SAMPLES_PATH . 'blank7p.jpg', 1, 1, 145, 105);
        $logo_path = SAMPLES_PATH . 'logo.png';
        if (file_exists($logo_path)) {
            $p = getimagesize($logo_path);
            $this->Image($logo_path, 10, 5, $p[0] / 5, $p[1] / 5);
        }
    }

    function PrintClientIndex($indx)
    {
        $this->SetFont('TimesNRCyrMT', '', 42);
        $indx = tocp1251($indx);
        if (isset($indx) and (mb_strlen($indx, 'windows-1251') >= 1)) {
            $i = 0;
            while ($i <= (mb_strlen($indx, 'windows-1251') - 1)) {
                $this->SetFont('Pechkin', '', 35);
                $this->SetXY(10.54 + $i * 8.75, 97.25);
                $this->Cell(0, 0, $indx[$i]);
                $this->SetFont('TimesNRCyrMT', '', 20);
                $this->SetXY(112.3 + $i * 5.0, 84.9);
                $this->Cell(0, 0, $indx[$i]);
                $i++;
            }
        }
    }

    function PrintShopIndex($indx)
    {
        $this->SetFont('TimesNRCyrMT', '', 20);
        $indx = tocp1251($indx);
        if (isset($indx) and (mb_strlen($indx, 'windows-1251') >= 1)) {
            $i = 0;
            while ($i <= (mb_strlen($indx, 'windows-1251') - 1)) {
                $this->SetXY(33.4 + $i * 4.9, 61.8);
                $this->Cell(0, 0, $indx[$i]);
                $i++;
            }
        }
    }

    function PrintShopName($name)
    {
        $this->SetFont('TimesNRCyrMT', '', 12);
        $name = tocp1251($name);
        $ans = multiStr($name, array(20));
        $this->SetXY(15, 38.3);
        $this->Cell(0, 0, $ans[0]);
        $this->SetXY(2, 46.0 - 1.9);
        $this->Cell(0, 0, $ans[1]);
    }

    function PrintClientName($name)
    {
        $this->SetFont('TimesNRCyrMT', '', 12);
        $name = tocp1251($name);
        $ans = multiStr($name, array(20));
        $this->SetXY(78, 60.8);
        $this->Cell(0, 0, $ans[0]);
        $this->SetXY(68.7, 67.2);
        $this->Cell(0, 0, $ans[1]);
    }

    function PrintShopAddr($address)
    {
        $this->SetFont('TimesNRCyrMT', '', 11);
        $address = tocp1251($address);
        $ans = multiStr($address, array(28, 33));
        $this->SetXY(15, 52.8 - 2.0);
        $this->Cell(0, 0, $ans[0]);
        $this->SetXY(2, 58.2 - 2.0);
        $this->Cell(0, 0, $ans[1]);
        $this->SetXY(2, 64.3 - 2.0);
        $this->Cell(0, 0, $ans[2]);
    }

    function PrintClientAddr($address)
    {
        $this->SetFont('TimesNRCyrMT', '', 11);
        $address = tocp1251($address);
        $ans = multiStr($address, array(28, 33));
        $this->SetXY(78, 73.0 + 0.4);
        $this->Cell(0, 0, $ans[0]);
        $this->SetXY(68, 73 + 6.4);
        $this->Cell(0, 0, $ans[1]);
        $this->SetXY(68, 73 + 12.4);
        $this->Cell(0, 0, $ans[2]);
    }

    function PrintSumObStr($sum)
    {
        $this->SetFont('TimesNRCyrMT', '', 17);
        $sumstr = tocp1251("(" . propis(floatval($sum), false) . ") руб.");
        $this->SetXY(66, 43.0);
        $this->Cell(0, 0, $sum);
        $l = strlen(strval($sum));
        $sumstr = multiStr($sumstr, array(50 - $l * 3));
        if (isset($sumstr[1])) {
            $this->SetFont('TimesNRCyrMT', '', 9);
            $this->SetXY(68 + $l * 2.7, 41.5);
            $this->Cell(0, 0, $sumstr[0]);
            $this->SetXY(68 + $l * 2.7, 44.3);
            $this->Cell(0, 0, $sumstr[1]);
        } else {
            $this->SetFont('TimesNRCyrMT', '', 10);
            $this->SetXY(68 + $l * 2.7, 42.9);
            $this->Cell(0, 0, $sumstr[0]);
        }
        $this->SetFont('TimesNRCyrMT', '', 8);
        $this->SetXY(33.8, 28.6);
        $this->Cell(0, 0, 'X');
    }

    function PrintSumNalStr($sum)
    {
        $this->SetFont('TimesNRCyrMT', '', 17);
        $sumstr = tocp1251("(" . propis(floatval($sum), false) . ") руб.");
        $this->SetXY(66, 54.0);
        $this->Cell(0, 0, $sum);
        $l = strlen(strval($sum));
        $sumstr = multiStr($sumstr, array(50 - $l * 3));
        if (isset($sumstr[1])) {
            $this->SetFont('TimesNRCyrMT', '', 9);
            $this->SetXY(68 + $l * 2.7, 51.7);
            $this->Cell(0, 0, $sumstr[0]);
            $this->SetXY(68 + $l * 2.7, 55.3);
            $this->Cell(0, 0, $sumstr[1]);
        } else {
            $this->SetFont('TimesNRCyrMT', '', 10);
            $this->SetXY(68 + $l * 2.7, 53.3);
            $this->Cell(0, 0, $sumstr[0]);
        }
        $this->SetFont('TimesNRCyrMT', '', 8);
        $this->SetXY(72.8, 28.6);
        $this->Cell(0, 0, 'X');
    }
}

class PDF_NewBlank7p extends FPDF
{
    function PrintPage($title, $pos)
    {
        $this->SetTitle($title);
        $this->AddFont('TimesNRCyrMT', '', 'timcyr.php');
        $this->AddPage('P');
        $this->Image(SAMPLES_PATH . 'newblank7p.jpg', 0, 0, 210, 145);
        $logo_path = SAMPLES_PATH . 'logo.png';
        if (file_exists($logo_path)) {
            $p = getimagesize($logo_path);
            $this->Image($logo_path, 10, 3, $p[0] / 5, $p[1] / 5);
        }
        $this->SetFont('TimesNRCyrMT', '', 12);
        if ($pos == 1) $this->SetXY(66.5, 20.3); else $this->SetXY(66.5, 27.3);
        $this->Cell(0, 0, 'X');
    }

    function PrintClientIndex($indx)
    {
        $this->SetFont('TimesNRCyrMT', '', 12);
        $indx = tocp1251($indx);
        if (isset($indx) and (mb_strlen($indx, 'windows-1251') >= 1)) {
            $i = 0;
            while ($i <= (mb_strlen($indx, 'windows-1251') - 1)) {
                $this->SetXY(161.3 + $i * 4.40, 120.5);
                $this->Cell(0, 0, $indx[$i]);
                $i++;
            }
        }
    }

    function PrintShopIndex($indx)
    {
        $this->SetFont('TimesNRCyrMT', '', 12);
        $indx = tocp1251($indx);
        if (isset($indx) and (mb_strlen($indx, 'windows-1251') >= 1)) {
            $i = 0;
            while ($i <= (mb_strlen($indx, 'windows-1251') - 1)) {
                $this->SetXY(72.7 + $i * 4.40, 92.99);
                $this->Cell(0, 0, $indx[$i]);
                $i++;
            }
        }
    }

    function PrintShopName($name)
    {
        $this->SetFont('TimesNRCyrMT', '', 12);
        $name = tocp1251($name);
        $this->SetXY(23, 57.3);
        $this->Cell(0, 0, $name);
    }

    function PrintClientName($name)
    {
        $this->SetFont('TimesNRCyrMT', '', 12);
        $name = tocp1251($name);
        $this->SetXY(113, 86.99 - 2.0);
        $this->Cell(0, 0, $name);
    }

    function PrintShopAddr($address)
    {
        $this->SetFont('TimesNRCyrMT', '', 11);
        $address = tocp1251($address);
        $ans = multiStr($address, array(38, 38));
        $this->SetXY(18, 76.8 - 2.0);
        $this->Cell(0, 0, $ans[0]);
        $this->SetXY(18, 81.99 - 2.0);
        $this->Cell(0, 0, $ans[1]);
        $this->SetXY(18, 86.18 - 2.0);
        $this->Cell(0, 0, $ans[2]);
    }

    function PrintClientAddr($address)
    {
        $this->SetFont('TimesNRCyrMT', '', 11);
        $address = tocp1251($address);
        $ans = multiStr($address, array(38, 38));
        $this->SetXY(107, 101.5 + 0.4);
        $this->Cell(0, 0, $ans[0]);
        $this->SetXY(107, 101.5 + 5.4);
        $this->Cell(0, 0, $ans[1]);
        $this->SetXY(107, 101.5 + 10.4);
        $this->Cell(0, 0, $ans[2]);
    }

    function PrintSumObStr($sum)
    {
        $this->SetFont('TimesNRCyrMT', '', 19);
        $sumstr = tocp1251("(" . propis(floatval($sum), false) . ") руб.");
        $this->SetXY(107, 54.0);
        $this->Cell(0, 0, $sum);
        $l = strlen(strval($sum));
        $sumstr = multiStr($sumstr, array(55 - $l * 4));
        if (isset($sumstr[1])) {
            $this->SetFont('TimesNRCyrMT', '', 10);
            $this->SetXY(109 + $l * 3.5, 52.5);
            $this->Cell(0, 0, $sumstr[0]);
            $this->SetXY(109 + $l * 3.5, 55.3);
            $this->Cell(0, 0, $sumstr[1]);
        } else {
            $this->SetFont('TimesNRCyrMT', '', 12);
            $this->SetXY(109 + $l * 3.5, 53.9);
            $this->Cell(0, 0, $sumstr[0]);
        }
        $this->SetFont('TimesNRCyrMT', '', 6);
        $this->SetXY(105.6, 19.6);
        $this->Cell(0, 0, 'X');
    }

    function PrintSumNalStr($sum)
    {
        $this->SetFont('TimesNRCyrMT', '', 19);
        $sumstr = tocp1251("(" . propis(floatval($sum), false) . ") руб. 00 коп.");
        $this->SetXY(107, 66.0);
        $this->Cell(0, 0, $sum);
        $l = strlen(strval($sum));
        $sumstr = multiStr($sumstr, array(50 - $l * 4));
        if (isset($sumstr[1])) {
            $this->SetFont('TimesNRCyrMT', '', 10);
            $this->SetXY(109 + $l * 3.5, 64.5);
            $this->Cell(0, 0, $sumstr[0]);
            $this->SetXY(109 + $l * 3.5, 67.3);
            $this->Cell(0, 0, $sumstr[1]);
        } else {
            $this->SetFont('TimesNRCyrMT', '', 12);
            $this->SetXY(109 + $l * 3.5, 65.9);
            $this->Cell(0, 0, $sumstr[0]);
        }
        $this->SetFont('TimesNRCyrMT', '', 6);
        $this->SetXY(105.6, 22.6);
        $this->Cell(0, 0, 'X');
    }

    function PrintShopPhone($indx)
    {
        $this->SetFont('TimesNRCyrMT', '', 12);
        $indx = tocp1251(substr(preg_replace('~[^0-9]+~', '', $indx), -10));
        if (isset($indx) and (mb_strlen($indx, 'windows-1251') >= 1)) {
            $i = 0;
            while ($i <= (mb_strlen($indx, 'windows-1251') - 1)) {
                $this->SetXY(23.3 + $i * 4.42, 92.99);
                $this->Cell(0, 0, $indx[$i]);
                $i++;
            }
        }
    }

    function PrintClientPhone($indx)
    {
        $this->SetFont('TimesNRCyrMT', '', 12);
        $indx = tocp1251(substr(preg_replace('~[^0-9]+~', '', $indx), -10));
        if (isset($indx) and (mb_strlen($indx, 'windows-1251') >= 1)) {
            $i = 0;
            while ($i <= (mb_strlen($indx, 'windows-1251') - 1)) {
                $this->SetXY(111.8 + $i * 4.42, 120.5);
                $this->Cell(0, 0, $indx[$i]);
                $i++;
            }
        }
    }
}

class PDF_NewBlank7a extends FPDF
{
    function PrintPage($title, $pos)
    {
        $this->SetTitle($title);
        $this->AddFont('TimesNRCyrMT', '', 'timcyr.php');
        $this->AddPage('P');
        $this->Image(SAMPLES_PATH . 'newblank7a.jpg', 0, 0, 210, 145);
        $logo_path = SAMPLES_PATH . 'logo.png';
        if (file_exists($logo_path)) {
            $p = getimagesize($logo_path);
            $this->Image($logo_path, 10, 3, $p[0] / 5, $p[1] / 5);
        }
        $this->SetFont('TimesNRCyrMT', '', 7);
        if ($pos == 1) $this->SetXY(63.5, 24.3); else $this->SetXY(63.5, 27.9);
        $this->Cell(0, 0, 'X');
    }

    function PrintClientIndex($indx)
    {
        $this->SetFont('TimesNRCyrMT', '', 12);
        $indx = tocp1251($indx);
        if (isset($indx) and (mb_strlen($indx, 'windows-1251') >= 1)) {
            $i = 0;
            while ($i <= (mb_strlen($indx, 'windows-1251') - 1)) {
                $this->SetXY(161.8 + $i * 4.40, 120.5 + 2.95);
                $this->Cell(0, 0, $indx[$i]);
                $i++;
            }
        }
    }

    function PrintShopIndex($indx)
    {
        $this->SetFont('TimesNRCyrMT', '', 12);
        $indx = tocp1251($indx);
        if (isset($indx) and (mb_strlen($indx, 'windows-1251') >= 1)) {
            $i = 0;
            while ($i <= (mb_strlen($indx, 'windows-1251') - 1)) {
                $this->SetXY(72.7 + $i * 4.40, 92.99 + 2.2);
                $this->Cell(0, 0, $indx[$i]);
                $i++;
            }
        }
    }

    function PrintShopPhone($indx)
    {
        $this->SetFont('TimesNRCyrMT', '', 12);
        $indx = tocp1251(substr(preg_replace('~[^0-9]+~', '', $indx), -10));
        if (isset($indx) and (mb_strlen($indx, 'windows-1251') >= 1)) {
            $i = 0;
            while ($i <= (mb_strlen($indx, 'windows-1251') - 1)) {
                $this->SetXY(23.3 + $i * 4.42, 92.99 + 2.3);
                $this->Cell(0, 0, $indx[$i]);
                $i++;
            }
        }
    }

    function PrintClientPhone($indx)
    {
        $this->SetFont('TimesNRCyrMT', '', 12);
        $indx = tocp1251(substr(preg_replace('~[^0-9]+~', '', $indx), -10));
        if (isset($indx) and (mb_strlen($indx, 'windows-1251') >= 1)) {
            $i = 0;
            while ($i <= (mb_strlen($indx, 'windows-1251') - 1)) {
                $this->SetXY(112.3 + $i * 4.42, 120.5 + 2.99);
                $this->Cell(0, 0, $indx[$i]);
                $i++;
            }
        }
    }

    function PrintShopName($name)
    {
        $this->SetFont('TimesNRCyrMT', '', 12);
        $name = tocp1251($name);
        $this->SetXY(23, 57.3 + 1.6);
        $this->Cell(0, 0, $name);
    }

    function PrintClientName($name)
    {
        $this->SetFont('TimesNRCyrMT', '', 12);
        $name = tocp1251($name);
        $this->SetXY(113, 86.99 - 2.0 + 2.2);
        $this->Cell(0, 0, $name);
    }

    function PrintShopAddr($address)
    {
        $this->SetFont('TimesNRCyrMT', '', 11);
        $address = tocp1251($address);
        $ans = multiStr($address, array(38, 38));
        $this->SetXY(18, 76.8 - 2.0 + 1.5);
        $this->Cell(0, 0, $ans[0]);
        $this->SetXY(18, 81.99 - 2.0 + 1.7);
        $this->Cell(0, 0, $ans[1]);
        $this->SetXY(18, 86.18 - 2.0 + 1.9);
        $this->Cell(0, 0, $ans[2]);
    }

    function PrintClientAddr($address)
    {
        $this->SetFont('TimesNRCyrMT', '', 11);
        $address = tocp1251($address);
        $ans = multiStr($address, array(38, 38));
        $this->SetXY(107, 101.5 + 0.4 + 2.5);
        $this->Cell(0, 0, $ans[0]);
        $this->SetXY(107, 101.5 + 5.4 + 2.5);
        $this->Cell(0, 0, $ans[1]);
        $this->SetXY(107, 101.5 + 10.4 + 2.5);
        $this->Cell(0, 0, $ans[2]);
    }

    function PrintSumObStr($sum)
    {
        $this->SetFont('TimesNRCyrMT', '', 19);
        $sumstr = tocp1251("(" . propis(floatval($sum), false) . ") руб.");
        $this->SetXY(107, 54.0 + 1.5);
        $this->Cell(0, 0, $sum);
        $l = strlen(strval($sum));
        $sumstr = multiStr($sumstr, array(55 - $l * 4));
        if (isset($sumstr[1])) {
            $this->SetFont('TimesNRCyrMT', '', 10);
            $this->SetXY(109 + $l * 3.5, 52.5 + 1.5);
            $this->Cell(0, 0, $sumstr[0]);
            $this->SetXY(109 + $l * 3.5, 55.3 + 1.5);
            $this->Cell(0, 0, $sumstr[1]);
        } else {
            $this->SetFont('TimesNRCyrMT', '', 12);
            $this->SetXY(109 + $l * 3.5, 53.9 + 1.5);
            $this->Cell(0, 0, $sumstr[0]);
        }
        $this->SetFont('TimesNRCyrMT', '', 6);
        $this->SetXY(105.8, 19.6 + 4.5);
        $this->Cell(0, 0, 'X');
    }

    function PrintSumNalStr($sum)
    {
        $this->SetFont('TimesNRCyrMT', '', 19);
        $sumstr = tocp1251("(" . propis(floatval($sum), false) . ") руб. 00 коп.");
        $this->SetXY(107, 66.0 + 1.5);
        $this->Cell(0, 0, $sum);
        $l = strlen(strval($sum));
        $sumstr = multiStr($sumstr, array(50 - $l * 4));
        if (isset($sumstr[1])) {
            $this->SetFont('TimesNRCyrMT', '', 10);
            $this->SetXY(109 + $l * 3.5, 64.5 + 1.5);
            $this->Cell(0, 0, $sumstr[0]);
            $this->SetXY(109 + $l * 3.5, 67.3 + 1.5);
            $this->Cell(0, 0, $sumstr[1]);
        } else {
            $this->SetFont('TimesNRCyrMT', '', 12);
            $this->SetXY(109 + $l * 3.5, 65.9 + 1.5);
            $this->Cell(0, 0, $sumstr[0]);
        }
        $this->SetFont('TimesNRCyrMT', '', 6);
        $this->SetXY(105.8, 22.6 + 4.5);
        $this->Cell(0, 0, 'X');
    }
}

class PDF_Sticker extends FPDF
{
    function PrintPage($name, $phone, $addr)
    {
        $this->AddFont('TimesNRCyrMT', '', 'timcyr.php');
        $this->AddPage('L');
        $logo_path = SAMPLES_PATH . 'logo.png';
        if (file_exists($logo_path)) {
            $p = getimagesize($logo_path);
            $this->Image($logo_path, 10, 3, $p[0] / 5, $p[1] / 5);
        }
        $this->Line(145, 0, 145, 105);
        $this->Line(0, 105, 145, 105);
        $this->SetFont('TimesNRCyrMT', '', 20);
        $this->SetXY(60.8, 10);
        $this->Cell(0, 0, parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST));
        $this->SetFont('TimesNRCyrMT', '', 20);
        $this->SetXY(10.8, 20);
        $this->Cell(0, 0, tocp1251("Получатель:"));
        $this->SetFont('TimesNRCyrMT', '', 20);
        $this->SetXY(10.8, 27);
        $this->Cell(0, 0, tocp1251($name));
        $this->SetFont('TimesNRCyrMT', '', 20);
        $this->SetXY(10.8, 34);
        $this->Cell(0, 0, tocp1251("+7" . normPhone($phone)));
        $this->SetFont('TimesNRCyrMT', '', 20);
        $this->SetXY(10.8, 41);
        $this->Cell(0, 0, tocp1251($addr));
        $this->SetFont('TimesNRCyrMT', '', 20);
        $this->SetXY(10.8, 50 + 10);
        $this->Cell(0, 0, tocp1251("Отправитель:"));
        $this->SetFont('TimesNRCyrMT', '', 20);
        $this->SetXY(10.8, 57 + 10);
        $this->Cell(0, 0, tocp1251($_POST["shop_name"]));
        $this->SetFont('TimesNRCyrMT', '', 20);
        $this->SetXY(10.8, 64 + 10);
        $this->Cell(0, 0, tocp1251("+7" . normPhone($_POST["shop_phone"])));
        $this->SetFont('TimesNRCyrMT', '', 20);
        $this->SetXY(10.8, 71 + 10);
        $this->Cell(0, 0, tocp1251($_POST["shop_addr"]));
    }
}

class PDF_Blank112ek extends FPDF
{
    function PrintPage($title)
    {
        $this->SetTitle($title);
        $this->AddFont('TimesNRCyrMT', '', 'timcyr.php');
        $this->AddPage('P');
        $this->Image(SAMPLES_PATH . 'blank112ek.jpg', 2, 2, 205, 290);
    }

    function PrintClientIndex($indx)
    {
        $this->SetFont('TimesNRCyrMT', '', 14);
        $indx = tocp1251($indx);
        if (isset($indx) and (mb_strlen($indx, 'windows-1251') >= 1)) {
            $i = 0;
            while ($i <= (mb_strlen($indx, 'windows-1251') - 1)) {
                $this->SetXY(178.6 + $i * 3.4, 117.6);
                $this->Cell(0, 0, $indx[$i]);
                $i++;
            }
        }
    }

    function PrintShopBankName($name)
    {
        $this->SetFont('TimesNRCyrMT', '', 15);
        $name = tocp1251($name);
        $this->SetXY(51, 125.5);
        $this->Cell(0, 0, $name);
    }

    function PrintShopBankKs($indx)
    {
        $this->SetFont('TimesNRCyrMT', '', 15);
        $indx = tocp1251($indx);
        if (isset($indx) and (mb_strlen($indx, 'windows-1251') >= 1)) {
            $i = 0;
            while ($i <= (mb_strlen($indx, 'windows-1251') - 1)) {
                $this->SetXY(105.4 + $i * 4.80, 119.3);
                $this->Cell(0, 0, $indx[$i]);
                $i++;
            }
        }
    }

    function PrintShopBankRs($indx)
    {
        $this->SetFont('TimesNRCyrMT', '', 15);
        $indx = tocp1251($indx);
        if (isset($indx) and (mb_strlen($indx, 'windows-1251') >= 1)) {
            $i = 0;
            while ($i <= (mb_strlen($indx, 'windows-1251') - 1)) {
                $this->SetXY(27.7 + $i * 4.8, 131.55);
                $this->Cell(0, 0, $indx[$i]);
                $i++;
            }
        }
    }

    function PrintShopBankBik($indx)
    {
        $indx = tocp1251($indx);
        if (isset($indx) and (mb_strlen($indx, 'windows-1251') >= 1)) {
            $i = 0;
            while ($i <= (mb_strlen($indx, 'windows-1251') - 1)) {
                $this->SetXY(158.0 + $i * 4.8, 131.6);
                $this->Cell(0, 0, $indx[$i]);
                $i++;
            }
        }
    }

    function PrintClientName($name)
    {
        $this->SetFont('TimesNRCyrMT', '', 12);
        $name = tocp1251($name);
        $this->SetXY(81, 107.2);
        $this->Cell(0, 0, $name);
    }

    function PrintShopName($name)
    {
        $this->SetFont('TimesNRCyrMT', '', 12);
        $name = tocp1251($name);
        $this->SetXY(75, 75.7);
        $this->Cell(0, 0, $name);
    }

    function PrintShopAddr($address)
    {
        $this->SetFont('TimesNRCyrMT', '', 11);
        $address = tocp1251($address);
        $ans = multiStr($address, array(58));
        $this->SetXY(75, 82.0);
        $this->Cell(0, 0, $ans[0]);
        $this->SetXY(68, 87.7);
        $this->Cell(0, 0, $ans[1]);
    }

    function PrintClientAddr($address)
    {
        $this->SetFont('TimesNRCyrMT', '', 11);
        $address = tocp1251($address);
        $ans = multiStr($address, array(48));
        $this->SetXY(99, 112.6);
        $this->Cell(0, 0, $ans[0]);
        $this->SetXY(67, 117.8);
        $this->Cell(0, 0, $ans[1]);
    }

    function PrintSumNal($val)
    {
        if ($val == '') return;
        $this->SetFont('TimesNRCyrMT', '', 12);
        $val = tocp1251($val);
        $val = floatval($val);
        $rub = floor($val) . '';
        $kop = round($val * 100 - floor($val) * 100);
        $kop = ($kop == 0 ? '00' : $kop . '');
        $this->SetXY(110, 57.5);
        $this->Cell(0, 0, $rub);
        $this->SetXY(129.9, 57.4);
        $this->Cell(0, 0, $kop);
        $this->SetFont('TimesNRCyrMT', '', 14);
        $this->SetXY(147.5, 57.3);
        $this->Cell(0, 0, 'X');
    }

    function PrintClientPhone($phone)
    {
        $this->SetFont('TimesNRCyrMT', '', 15);
        $phone = tocp1251($phone);
        if (isset($phone) and (mb_strlen($phone, 'windows-1251') >= 1)) {
            $i = 0;
            while ($i <= (mb_strlen($phone, 'windows-1251') - 1)) {
                $this->SetXY(160.3 + $i * 3.835, 70.2);
                $this->Cell(0, 0, $phone[$i]);
                $i++;
            }
        }
    }

    function PrintSumNalStr($sum)
    {
        $this->SetFont('TimesNRCyrMT', '', 12);
        $sum = tocp1251($sum);
        $this->SetXY(65.0, 62.5);
        $this->Cell(0, 0, $sum);
    }

    function PrintShopInn($inn)
    {
        $this->SetFont('TimesNRCyrMT', '', 15);
        $inn = tocp1251($inn);
        if (isset($inn) and (mb_strlen($inn, 'windows-1251') >= 1)) {
            $i = 0;
            while ($i <= (mb_strlen($inn, 'windows-1251') - 1)) {
                $this->SetXY(20.8 + $i * 4.76, 119.5);
                $this->Cell(0, 0, $inn[$i]);
                $i++;
            }
        }
    }
}

class PDF_NewBlank7p_6a extends FPDF
{
    function PrintPage($title, $pos)
    {
        $this->SetTitle($title);
        $this->AddFont('TimesNRCyrMT', '', 'timcyr.php');
        $this->AddPage('L');
        $this->Image(SAMPLES_PATH . 'newblank7p.jpg', 0, 0, 145, 105);
        $logo_path = SAMPLES_PATH . 'logo.png';
        if (file_exists($logo_path)) {
            $p = getimagesize($logo_path);
            $this->Image($logo_path, 10, 3, $p[0] / 5, $p[1] / 5);
        }
        $this->SetFont('TimesNRCyrMT', '', 9);
        if ($pos == 1) $this->SetXY(66.5 * 0.685, 20.3 * 0.724); else $this->SetXY(66.5 * 0.685, 27.3 * 0.724);
        $this->Cell(0, 0, 'X');
    }

    function PrintClientIndex($indx)
    {
        $this->SetFont('TimesNRCyrMT', '', 9);
        $indx = tocp1251($indx);
        if (isset($indx) and (mb_strlen($indx, 'windows-1251') >= 1)) {
            $i = 0;
            while ($i <= (mb_strlen($indx, 'windows-1251') - 1)) {
                $this->SetXY(161.3 * 0.687 + $i * 3.10, 120.5 * 0.724);
                $this->Cell(0, 0, $indx[$i]);
                $i++;
            }
        }
    }

    function PrintShopIndex($indx)
    {
        $this->SetFont('TimesNRCyrMT', '', 9);
        $indx = tocp1251($indx);
        if (isset($indx) and (mb_strlen($indx, 'windows-1251') >= 1)) {
            $i = 0;
            while ($i <= (mb_strlen($indx, 'windows-1251') - 1)) {
                $this->SetXY((72.7 * 0.687 + $i * 3.10), 92.99 * 0.724);
                $this->Cell(0, 0, $indx[$i]);
                $i++;
            }
        }
    }

    function PrintShopName($name)
    {
        $this->SetFont('TimesNRCyrMT', '', 9);
        $name = tocp1251($name);
        $this->SetXY(23 * 0.685, 57.3 * 0.724);
        $this->Cell(0, 0, $name);
    }

    function PrintClientName($name)
    {
        $this->SetFont('TimesNRCyrMT', '', 9);
        $name = tocp1251($name);
        $this->SetXY(113 * 0.685, 84.99 * 0.724);
        $this->Cell(0, 0, $name);
    }

    function PrintShopAddr($address)
    {
        $this->SetFont('TimesNRCyrMT', '', 8);
        $address = tocp1251($address);
        $ans = multiStr($address, array(38, 38));
        $this->SetXY(18 * 0.685, 74.8 * 0.724);
        $this->Cell(0, 0, $ans[0]);
        $this->SetXY(18 * 0.685, 79.99 * 0.724);
        $this->Cell(0, 0, $ans[1]);
        $this->SetXY(18 * 0.685, 84.18 * 0.724);
        $this->Cell(0, 0, $ans[2]);
    }

    function PrintClientAddr($address)
    {
        $this->SetFont('TimesNRCyrMT', '', 8);
        $address = tocp1251($address);
        $ans = multiStr($address, array(38, 38));
        $this->SetXY(107 * 0.685, 101.9 * 0.724);
        $this->Cell(0, 0, $ans[0]);
        $this->SetXY(107 * 0.685, 106.9 * 0.724);
        $this->Cell(0, 0, $ans[1]);
        $this->SetXY(107 * 0.685, 111.9 * 0.724);
        $this->Cell(0, 0, $ans[2]);
    }

    function PrintSumObStr($sum)
    {
        $this->SetFont('TimesNRCyrMT', '', 15);
        $sumstr = tocp1251("(" . propis(floatval($sum), false) . ") руб.");
        $this->SetXY(107 * 0.685, 54.0 * 0.724);
        $this->Cell(0, 0, $sum);
        $l = strlen(strval($sum));
        $sumstr = multiStr($sumstr, array(55 - $l * 4));
        if (isset($sumstr[1])) {
            $this->SetFont('TimesNRCyrMT', '', 7);
            $this->SetXY((109 + $l * 3.5) * 0.685, 52.5 * 0.724);
            $this->Cell(0, 0, $sumstr[0]);
            $this->SetXY((109 + $l * 3.5) * 0.685, 55.3 * 0.724);
            $this->Cell(0, 0, $sumstr[1]);
        } else {
            $this->SetFont('TimesNRCyrMT', '', 9);
            $this->SetXY((109 + $l * 3.5) * 0.685, 53.9 * 0.724);
            $this->Cell(0, 0, $sumstr[0]);
        }
        $this->SetFont('TimesNRCyrMT', '', 5);
        $this->SetXY(105.6 * 0.685, 19.6 * 0.724);
        $this->Cell(0, 0, 'X');
    }

    function PrintSumNalStr($sum)
    {
        $this->SetFont('TimesNRCyrMT', '', 15);
        $sumstr = tocp1251("(" . propis(floatval($sum), false) . ") руб. 00 коп.");
        $this->SetXY(107 * 0.685, 66.0 * 0.724);
        $this->Cell(0, 0, $sum);
        $l = strlen(strval($sum));
        $sumstr = multiStr($sumstr, array(50 - $l * 4));
        if (isset($sumstr[1])) {
            $this->SetFont('TimesNRCyrMT', '', 7);
            $this->SetXY((109 + $l * 3.5) * 0.685, 64.5 * 0.724);
            $this->Cell(0, 0, $sumstr[0]);
            $this->SetXY((109 + $l * 3.5) * 0.685, 67.3 * 0.724);
            $this->Cell(0, 0, $sumstr[1]);
        } else {
            $this->SetFont('TimesNRCyrMT', '', 9);
            $this->SetXY((109 + $l * 3.5) * 0.685, 65.9 * 0.724);
            $this->Cell(0, 0, $sumstr[0]);
        }
        $this->SetFont('TimesNRCyrMT', '', 5);
        $this->SetXY(105.6 * 0.685, 22.6 * 0.724);
        $this->Cell(0, 0, 'X');
    }

    function PrintShopPhone($indx)
    {
        $this->SetFont('TimesNRCyrMT', '', 9);
        $indx = tocp1251(substr(preg_replace('~[^0-9]+~', '', $indx), -10));
        if (isset($indx) and (mb_strlen($indx, 'windows-1251') >= 1)) {
            $i = 0;
            while ($i <= (mb_strlen($indx, 'windows-1251') - 1)) {
                $this->SetXY((23.3 + $i * 4.42) * 0.685, 92.99 * 0.724);
                $this->Cell(0, 0, $indx[$i]);
                $i++;
            }
        }
    }

    function PrintClientPhone($indx)
    {
        $this->SetFont('TimesNRCyrMT', '', 9);
        $indx = tocp1251(substr(preg_replace('~[^0-9]+~', '', $indx), -10));
        if (isset($indx) and (mb_strlen($indx, 'windows-1251') >= 1)) {
            $i = 0;
            while ($i <= (mb_strlen($indx, 'windows-1251') - 1)) {
                $this->SetXY((111.8 + $i * 4.42) * 0.685, 120.5 * 0.724);
                $this->Cell(0, 0, $indx[$i]);
                $i++;
            }
        }
    }
}

class PDF_Blank112_new_7p extends FPDF
{
    function PrintPage($title)
    {
        $this->SetTitle($title);
        $this->AddFont('TimesNRCyrMT', '', 'timcyr.php');
        $this->AddPage('L');
        $this->Image(SAMPLES_PATH . 'blank112.jpg', 151, 1, 145, 206);
    }

    function PrintClientIndex($indx)
    {
        $v = 0.71345;
        $h = 0.6868;
        $indx = tocp1251($indx);
        if (isset($indx) and (mb_strlen($indx, 'windows-1251') >= 1)) {
            $i = 0;
            while ($i <= (mb_strlen($indx, 'windows-1251') - 1)) {
                $this->SetFont('TimesNRCyrMT', '', 16);
                $this->SetXY(269.9 + $i * 3.55, 107.2);
                $this->Cell(0, 0, $indx[$i]);
                $i++;
            }
        }
    }

    function PrintShopIndex($indx)
    {
        $v = 0.71345;
        $h = 0.6168;
        $indx = tocp1251($indx);
        if (isset($indx) and (mb_strlen($indx, 'windows-1251') >= 1)) {
            $i = 0;
            while ($i <= (mb_strlen($indx, 'windows-1251') - 1)) {
                $this->SetFont('TimesNRCyrMT', '', 16);
                $this->SetXY(269.9 + $i * 3.55, 65.4);
                $this->Cell(0, 0, $indx[$i]);
                $i++;
            }
        }
    }

    function PrintClientName($name)
    {
        $this->SetFont('TimesNRCyrMT', '', 11);
        $name = tocp1251($name);
        $v = 0.70245;
        $h = 0.6168;
        $this->SetXY(167, 97.3);
        $this->Cell(0, 0, $name);
    }

    function PrintShopName($name)
    {
        $v = 0.70245;
        $h = 0.6168;
        $this->SetFont('TimesNRCyrMT', '', 11);
        $name = tocp1251($name);
        $this->SetXY(163, 55.7);
        $this->Cell(0, 0, $name);
    }

    function PrintShopAddr($address)
    {
        $this->SetFont('TimesNRCyrMT', '', 11);
        $address = tocp1251($address);
        $ans = multiStr($address, array(70));
        $this->SetXY(163, 60.6);
        $this->Cell(0, 0, $ans[0]);
        $this->SetXY(155, 65.5);
        $this->Cell(0, 0, $ans[1]);
    }

    function PrintClientAddr($address)
    {
        $this->SetFont('TimesNRCyrMT', '', 11);
        $address = tocp1251($address);
        $ans = multiStr($address, array(55));
        $this->SetXY(184, 102.5);
        $this->Cell(0, 0, $ans[0]);
        $this->SetXY(155, 107.4);
        $this->Cell(0, 0, $ans[1]);
    }

    function PrintShopPhone($phone)
    {
        $this->SetFont('TimesNRCyrMT', '', 13);
        $phone = tocp1251($phone);
        if (isset($phone) and (mb_strlen($phone, 'windows-1251') >= 1)) {
            $i = 0;
            while ($i <= (mb_strlen($phone, 'windows-1251') - 1)) {
                $this->SetXY(262.7 + $i * 2.86, 46.7);
                $this->Cell(0, 0, $phone[$i]);
                $i++;
            }
        }
    }

    function PrintClientPhone($phone)
    {
        $this->SetFont('TimesNRCyrMT', '', 13);
        $phone = tocp1251($phone);
        if (isset($phone) and (mb_strlen($phone, 'windows-1251') >= 1)) {
            $i = 0;
            while ($i <= (mb_strlen($phone, 'windows-1251') - 1)) {
                $this->SetXY(262.7 + $i * 2.86, 51.2);
                $this->Cell(0, 0, $phone[$i]);
                $i++;
            }
        }
    }

    function PrintSumNalStr($sum)
    {
        $this->SetFont('TimesNRCyrMT', '', 13);
        $this->SetXY(156.8, 43.4);
        $this->Cell(0, 0, $sum);
        $this->SetXY(175.8, 43.4);
        $this->Cell(0, 0, "00");
        $this->SetFont('TimesNRCyrMT', '', 18);
        $this->SetXY(155, 49.9);
        $this->Cell(0, 0, "X");
        $this->SetFont('TimesNRCyrMT', '', 11);
        $sumstr = tocp1251(propis(floatval($sum), true));
        $this->SetXY(189.8, 39.9);
        $this->Cell(0, 0, $sumstr);
    }

    function PrintShopInn($inn)
    {
        $this->SetFont('TimesNRCyrMT', '', 12);
        $inn = tocp1251($inn);
        if (isset($inn) and (mb_strlen($inn, 'windows-1251') >= 1)) {
            $i = 0;
            while ($i <= (mb_strlen($inn, 'windows-1251') - 1)) {
                $this->SetXY(163.5 + $i * 3.41, 83.9);
                $this->Cell(0, 0, $inn[$i]);
                $i++;
            }
        }
    }

    function PrintShopBankKs($indx)
    {
        $this->SetFont('TimesNRCyrMT', '', 12);
        $indx = tocp1251($indx);
        if (isset($indx) and (mb_strlen($indx, 'windows-1251') >= 1)) {
            $i = 0;
            while ($i <= (mb_strlen($indx, 'windows-1251') - 1)) {
                $this->SetXY(223.9 + $i * 3.39, 83.9);
                $this->Cell(0, 0, $indx[$i]);
                $i++;
            }
        }
    }

    function PrintShopBankRs($indx)
    {
        $this->SetFont('TimesNRCyrMT', '', 12);
        $indx = tocp1251($indx);
        if (isset($indx) and (mb_strlen($indx, 'windows-1251') >= 1)) {
            $i = 0;
            while ($i <= (mb_strlen($indx, 'windows-1251') - 1)) {
                $this->SetXY(168.5 + $i * 3.40, 92.85);
                $this->Cell(0, 0, $indx[$i]);
                $i++;
            }
        }
    }

    function PrintShopBankBik($indx)
    {
        $this->SetFont('TimesNRCyrMT', '', 12);
        $indx = tocp1251($indx);
        if (isset($indx) and (mb_strlen($indx, 'windows-1251') >= 1)) {
            $i = 0;
            while ($i <= (mb_strlen($indx, 'windows-1251') - 1)) {
                $this->SetXY(261.3 + $i * 3.380, 92.85);
                $this->Cell(0, 0, $indx[$i]);
                $i++;
            }
        }
    }

    function PrintShopBankName($name)
    {
        $this->SetFont('TimesNRCyrMT', '', 11);
        $name = tocp1251($name);
        $this->SetXY(186, 88.4);
        $this->Cell(0, 0, $name);
    }

    function Rotate($angle, $x = -1, $y = -1)
    {
        if ($x == -1) $x = $this->x;
        if ($y == -1) $y = $this->y;
        if ($this->angle != 0) $this->_out('Q');
        $this->angle = $angle;
        if ($angle != 0) {
            $angle *= M_PI / 180;
            $c = cos($angle);
            $s = sin($angle);
            $cx = $x * $this->k;
            $cy = ($this->h - $y) * $this->k;
            $this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm', $c, $s, -$s, $c, $cx, $cy, -$cx, -$cy));
        }
    }

    function RotatedText($x, $y, $txt, $angle)
    {
        $this->Rotate($angle, $x, $y);
        $this->Text($x, $y, $txt);
        $this->Rotate(0);
    }

    function RotatedImage($file, $x, $y, $w, $h, $angle)
    {
        $this->Rotate($angle, $x, $y);
        $this->Image($file, $x, $y, $w, $h);
        $this->Rotate(0);
    }

    function PrintPage_7p($title, $pos)
    {
        $this->SetFont('TimesNRCyrMT', '', 12);
        $this->RotatedImage(SAMPLES_PATH . 'newblank7p.jpg', 0, 210, 210, 145, 90);
    }

    function PrintClientIndex_7p($indx)
    {
        $this->SetFont('TimesNRCyrMT', '', 12);
        $indx = tocp1251($indx);
        if (isset($indx) and (mb_strlen($indx, 'windows-1251') >= 1)) {
            $slen = mb_strlen($indx, 'windows-1251');
            $i = 0;
            while ($i < $slen) {
                $this->RotatedText(121.5, 187 - 161.3 + $i * 4.40, $indx[$slen - $i - 1], 90);
                $i++;
            }
        }
    }

    function PrintShopIndex_7p($indx)
    {
        $this->SetFont('TimesNRCyrMT', '', 12);
        $indx = tocp1251($indx);
        if (isset($indx) and (mb_strlen($indx, 'windows-1251') >= 1)) {
            $slen = mb_strlen($indx, 'windows-1251');
            $i = 0;
            while ($i < $slen) {
                $this->RotatedText(93.99, 187 - 72.7 + $i * 4.40, $indx[$slen - $i - 1], 90);
                $i++;
            }
        }
    }

    function PrintShopName_7p($name)
    {
        $this->SetFont('TimesNRCyrMT', '', 12);
        $name = tocp1251($name);
        $this->RotatedText(58.8, 209 - 23, $name, 90);
    }

    function PrintClientName_7p($name)
    {
        $this->SetFont('TimesNRCyrMT', '', 12);
        $name = tocp1251($name);
        $this->RotatedText(86.59, 209 - 113, $name, 90);
    }

    function PrintShopAddr_7p($address)
    {
        $this->SetFont('TimesNRCyrMT', '', 11);
        $address = tocp1251($address);
        $ans = multiStr($address, array(38, 38));
        $this->RotatedText(74.8 + 1, 210 - 18, $ans[0], 90);
        $this->RotatedText(79.99 + 1, 210 - 18, $ans[1], 90);
        $this->RotatedText(84.18 + 1, 210 - 18, $ans[2], 90);
    }

    function PrintClientAddr_7p($address)
    {
        $this->SetFont('TimesNRCyrMT', '', 11);
        $address = tocp1251($address);
        $ans = multiStr($address, array(38, 38));
        $this->RotatedText(101.9, 209 - 107, $ans[0], 90);
        $this->RotatedText(106.9, 209 - 107, $ans[1], 90);
        $this->RotatedText(111.9, 209 - 107, $ans[2], 90);
    }

    function PrintSumObStr_7p($sum)
    {
        $this->SetFont('TimesNRCyrMT', '', 19);
        $sumstr = tocp1251("(" . propis(floatval($sum), false) . ") руб.");
        $this->RotatedText(55.0, 209 - 107, $sum, 90);
        $l = strlen(strval($sum));
        $sumstr = multiStr($sumstr, array(55 - $l * 4));
        if (isset($sumstr[1])) {
            $this->SetFont('TimesNRCyrMT', '', 10);
            $this->RotatedText(52.5, 174 - 109 + $l * 3.5, $sumstr[0], 90);
            $this->RotatedText(55.3, 174 - 109 + $l * 3.5, $sumstr[1], 90);
        } else {
            $this->SetFont('TimesNRCyrMT', '', 12);
            $this->RotatedText(53.9, 187 - 109 + $l * 3.5, $sumstr[0], 90);
        }
        $this->SetFont('TimesNRCyrMT', '', 6);
        $this->RotatedText(19.6, 209 - 105.6, "X", 90);
    }

    function PrintSumNalStr_7p($sum)
    {
        $this->SetFont('TimesNRCyrMT', '', 19);
        $sumstr = tocp1251("(" . propis(floatval($sum), false) . ") руб. 00 коп.");
        $this->RotatedText(67, 209 - 107, $sum, 90);
        $l = strlen(strval($sum));
        $sumstr = multiStr($sumstr, array(50 - $l * 4));
        if (isset($sumstr[1])) {
            $this->SetFont('TimesNRCyrMT', '', 10);
            $this->RotatedText(64.5, 174 - 109 + $l * 3.5, $sumstr[0], 90);
            $this->RotatedText(67.3, 174 - 109 + $l * 3.5, $sumstr[1], 90);
        } else {
            $this->SetFont('TimesNRCyrMT', '', 12);
            $this->RotatedText(65.9, 187 - 109 + $l * 3.5, $sumstr[0], 90);
        }
        $this->SetFont('TimesNRCyrMT', '', 6);
        $this->RotatedText(22.6, 209 - 105.6, "X", 90);
    }

    function PrintShopPhone_7p($indx)
    {
        $this->SetFont('TimesNRCyrMT', '', 12);
        $indx = tocp1251(substr(preg_replace('~[^0-9]+~', '', $indx), -10));
        if (isset($indx) and (mb_strlen($indx, 'windows-1251') >= 1)) {
            $slen = mb_strlen($indx, 'windows-1251');
            $i = 0;
            while ($i < $slen) {
                $this->RotatedText(93.99, 169 - 23.3 + $i * 4.52, $indx[$slen - $i - 1], 90);
                $i++;
            }
        }
    }

    function PrintClientPhone_7p($indx)
    {
        $this->SetFont('TimesNRCyrMT', '', 12);
        $indx = tocp1251(substr(preg_replace('~[^0-9]+~', '', $indx), -10));
        if (isset($indx) and (mb_strlen($indx, 'windows-1251') >= 1)) {
            $slen = mb_strlen($indx, 'windows-1251');
            $i = 0;
            while ($i < $slen) {
                $this->RotatedText(121.5, 169 - 111.8 + ($i) * 4.52, $indx[$slen - $i - 1], 90);
                $i++;
            }
        }
    }
}

class PDF_Sticker_2 extends FPDF
{
    function PrintPage($name, $phone, $addr)
    {
        $this->AddFont('TimesNRCyrMT', '', 'timcyr.php');
        $this->AddPage('L');
        $logo_path = SAMPLES_PATH . 'logo.png';
        if (file_exists($logo_path)) {
            $p = getimagesize($logo_path);
            $this->Image($logo_path, 10, 3, $p[0] / 5, $p[1] / 5);
        }
        $this->Line(145, 0, 145, 105);
        $this->Line(0, 105, 145, 105);
        $this->SetFont('TimesNRCyrMT', '', 17);
        $this->SetXY(60.8, 10);
        $this->Cell(0, 0, parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST));
        $this->SetXY(10.8, 20);
        $this->Cell(0, 0, tocp1251("Получатель:"));
        $this->SetXY(10.8, 27);
        $this->Cell(0, 0, tocp1251($name));
        $this->SetXY(10.8, 34);
        $this->Cell(0, 0, tocp1251("+7" . normPhone($phone)));
        $addr = tocp1251($addr);
        $ans = multiStr($addr, array(40, 40));
        $this->SetXY(10.8, 41);
        $this->Cell(0, 0, $ans[0]);
        $this->SetXY(10.8, 47);
        $this->Cell(0, 0, $ans[1]);
        $this->SetXY(10.8, 53);
        $this->Cell(0, 0, $ans[2]);
        $this->SetXY(10.8, 50 + 20);
        $this->Cell(0, 0, tocp1251("Отправитель:"));
        $this->SetXY(10.8, 57 + 20);
        $this->Cell(0, 0, tocp1251($_POST["shop_name"]));
        $this->SetXY(10.8, 64 + 20);
        $this->Cell(0, 0, tocp1251("+7" . normPhone($_POST["shop_phone"])));
        $this->SetXY(10.8, 71 + 20);
        $this->Cell(0, 0, tocp1251($_POST["shop_addr"]));
    }
}

error_reporting(E_ALL & ~E_NOTICE);
if (validate(parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST))) if (isset($_POST["blank_type"]) && !empty($_POST["blank_type"])) {
    switch ($_POST["blank_type"]) {
        case "b112ek":
            print_blank112ek();
            break;
        case "b112ep":
            print_blank112();
            break;
        case "b116":
            print_blank116(false);
            break;
        case "o107":
            print_opis107();
            break;
        case "b7a":
            print_blank7a();
            break;
        case "b7b":
            print_blank7b();
            break;
        case "b7p":
            print_blank7p();
            break;
        case "b7p2":
            print_blank7p2();
            break;
        case "b112116":
            print_blank112116();
            break;
        case "bcn23":
            print_blankcn23();
            break;
        case "bcp71":
            print_blankcp71();
            break;
        case "bfind":
            print_blankfind();
            break;
        case "b116_2":
            print_blank116(true);
            break;
        case "b116_2_a5":
            print_blank116_2();
            break;
        case "b116_origin":
            print_blank116_origin();
            break;
        case "b112_a5":
            print_blank112_a5();
            break;
        case "new_b7p_p":
            print_newblank7p(1);
            break;
        case "new_b7p_b":
            print_newblank7p(2);
            break;
        case "new_b7a_p":
            print_newblank7a(1);
            break;
        case "new_b7a_b":
            print_newblank7a(2);
            break;
        case "sticker":
            print_sticker();
            break;
        case "sticker_2":
            print_sticker_2();
            break;
        case "new_b7p_6a":
            print_newblank7p_6a(1);
        case "new_b7p_112":
            print_blank112_new_7p();
            break;
        default:
            error("К сожалению, этот почтовый бланк не поддерживается. Если это стало для Вас неожиданностью - напишите мне: printblank@nikitabatov.ru");
    }
} else error("К сожалению, что-то пошло не так. Не указан тип бланка. Если это сообщение для Вас неожиданность - напишите мне: printblank@nikitabatov.ru");
function validate($url)
{
    return true;
}

function print_blank112_new_7p()
{
    $file_name = fileName($_POST["blank_type"], $_POST['client_name'], $_POST['client_index']);
    $doc = new PDF_Blank112_new_7p('L', 'mm', 'A4');
    $doc->Open();
    $doc->PrintPage($file_name);
    $doc->PrintShopIndex($_POST['shop_index']);
    $doc->PrintClientIndex($_POST['client_index']);
    $doc->PrintClientName($_POST['client_name']);
    $doc->PrintShopName($_POST['shop_name']);
    $doc->PrintShopAddr($_POST['shop_addr']);
    $doc->PrintClientAddr($_POST['client_addr']);
    if (isset($_POST["sum_nal"]) && !empty($_POST["sum_nal"])) $doc->PrintSumNalStr($_POST['sum_nal']);
    $doc->PrintShopPhone(normPhone($_POST['shop_phone']));
    $doc->PrintClientPhone(normPhone($_POST['client_phone']));
    $doc->PrintShopBankName($_POST['shop_bank_name']);
    $doc->PrintShopBankRs($_POST['shop_bank_rs']);
    $doc->PrintShopBankKs($_POST['shop_bank_ks']);
    $doc->PrintShopBankBik($_POST['shop_bank_bik']);
    $doc->PrintShopInn($_POST['shop_inn']);
    $doc->PrintPage_7p($file_name, 1);
    $doc->PrintShopPhone_7p($_POST['shop_phone']);
    $doc->PrintClientPhone_7p($_POST['client_phone']);
    $doc->PrintShopIndex_7p($_POST['shop_index']);
    $doc->PrintClientIndex_7p($_POST['client_index']);
    $doc->PrintClientName_7p($_POST['client_name']);
    $doc->PrintShopName_7p($_POST['shop_name']);
    $doc->PrintShopAddr_7p($_POST['shop_addr']);
    $doc->PrintClientAddr_7p($_POST['client_addr']);
    if (isset($_POST["sum_ob"]) && !empty($_POST["sum_ob"])) $doc->PrintSumObStr_7p($_POST['sum_ob']);
    if (isset($_POST["sum_nal"]) && !empty($_POST["sum_nal"])) $doc->PrintSumNalStr_7p($_POST['sum_nal']);
    $doc->Output($file_name . ".pdf", I);
}

function print_blank112ek()
{
    $file_name = fileName($_POST["blank_type"], $_POST['client_name'], $_POST['client_index']);
    $doc = new PDF_Blank112ek('L', 'mm', 'A4');
    $doc->Open();
    $doc->PrintPage($file_name);
    $doc->PrintClientIndex($_POST['client_index']);
    $doc->PrintClientName($_POST['client_name']);
    $doc->PrintShopName($_POST['shop_name']);
    $doc->PrintShopAddr($_POST['shop_addr']);
    $doc->PrintClientAddr($_POST['client_addr']);
    $doc->PrintSumNal($_POST['sum_nal']);
    if (isset($_POST["sum_nal"]) && !empty($_POST["sum_nal"])) $doc->PrintSumNalStr(propis(floatval($_POST['sum_nal']), true));
    $doc->PrintClientPhone(normPhone($_POST['client_phone']));
    $doc->PrintShopBankName($_POST['shop_bank_name']);
    $doc->PrintShopBankRs($_POST['shop_bank_rs']);
    $doc->PrintShopBankKs($_POST['shop_bank_ks']);
    $doc->PrintShopBankBik($_POST['shop_bank_bik']);
    $doc->PrintShopInn($_POST['shop_inn']);
    $doc->Output($file_name . ".pdf", I);
}

function print_sticker()
{
    $doc = new PDF_Sticker('L', 'mm', 'A4');
    $doc->Open();
    $doc->PrintPage($_POST['client_name'], $_POST['client_phone'], $_POST['client_city']);
    $doc->Output($file_name . ".pdf", I);
}

function print_sticker_2()
{
    $doc = new PDF_Sticker_2('L', 'mm', 'A4');
    $doc->Open();
    $doc->PrintPage($_POST['client_name'], $_POST['client_phone'], $_POST['client_index'] . ", " . $_POST['client_addr']);
    $doc->Output($file_name . ".pdf", I);
}

function print_newblank7a($pos)
{
    $file_name = fileName($_POST["blank_type"], $_POST['client_name'], $_POST['client_index']);
    $doc = new PDF_NewBlank7a('L', 'mm', 'A4');
    $doc->Open();
    $doc->PrintPage($file_name, $pos);
    $doc->PrintShopIndex($_POST['shop_index']);
    $doc->PrintShopPhone($_POST['shop_phone']);
    $doc->PrintClientPhone($_POST['client_phone']);
    $doc->PrintClientIndex($_POST['client_index']);
    $doc->PrintClientName($_POST['client_name']);
    $doc->PrintShopName($_POST['shop_name']);
    $doc->PrintShopAddr($_POST['shop_addr']);
    $doc->PrintClientAddr($_POST['client_addr']);
    if (isset($_POST["sum_ob"]) && !empty($_POST["sum_ob"])) $doc->PrintSumObStr($_POST['sum_ob']);
    if (isset($_POST["sum_nal"]) && !empty($_POST["sum_nal"])) $doc->PrintSumNalStr($_POST['sum_nal']);
    $doc->Output($file_name . ".pdf", I);
}

function print_newblank7p_6a($pos)
{
    $file_name = fileName($_POST["blank_type"], $_POST['client_name'], $_POST['client_index']);
    $doc = new PDF_NewBlank7p_6a('P', 'mm', 'A4');
    $doc->Open();
    $doc->PrintPage($file_name, $pos);
    $doc->PrintShopPhone($_POST['shop_phone']);
    $doc->PrintClientPhone($_POST['client_phone']);
    $doc->PrintShopIndex($_POST['shop_index']);
    $doc->PrintClientIndex($_POST['client_index']);
    $doc->PrintClientName($_POST['client_name']);
    $doc->PrintShopName($_POST['shop_name']);
    $doc->PrintShopAddr($_POST['shop_addr']);
    $doc->PrintClientAddr($_POST['client_addr']);
    if (isset($_POST["sum_ob"]) && !empty($_POST["sum_ob"])) $doc->PrintSumObStr($_POST['sum_ob']);
    if (isset($_POST["sum_nal"]) && !empty($_POST["sum_nal"])) $doc->PrintSumNalStr($_POST['sum_nal']);
    $doc->Output($file_name . ".pdf", I);
}

function print_newblank7p($pos)
{
    $file_name = fileName($_POST["blank_type"], $_POST['client_name'], $_POST['client_index']);
    $doc = new PDF_NewBlank7p('L', 'mm', 'A4');
    $doc->Open();
    $doc->PrintPage($file_name, $pos);
    $doc->PrintShopPhone($_POST['shop_phone']);
    $doc->PrintClientPhone($_POST['client_phone']);
    $doc->PrintShopIndex($_POST['shop_index']);
    $doc->PrintClientIndex($_POST['client_index']);
    $doc->PrintClientName($_POST['client_name']);
    $doc->PrintShopName($_POST['shop_name']);
    $doc->PrintShopAddr($_POST['shop_addr']);
    $doc->PrintClientAddr($_POST['client_addr']);
    if (isset($_POST["sum_ob"]) && !empty($_POST["sum_ob"])) $doc->PrintSumObStr($_POST['sum_ob']);
    if (isset($_POST["sum_nal"]) && !empty($_POST["sum_nal"])) $doc->PrintSumNalStr($_POST['sum_nal']);
    $doc->Output($file_name . ".pdf", I);
}

function print_blank112()
{
    $file_name = fileName($_POST["blank_type"], $_POST['client_name'], $_POST['client_index']);
    $doc = new PDF_Blank112('L', 'mm', 'A4');
    $doc->Open();
    $doc->PrintPage($file_name);
    $doc->PrintShopIndex($_POST['shop_index']);
    $doc->PrintClientIndex($_POST['client_index']);
    $doc->PrintClientName($_POST['client_name']);
    $doc->PrintShopName($_POST['shop_name']);
    $doc->PrintShopAddr($_POST['shop_addr']);
    $doc->PrintClientAddr($_POST['client_addr']);
    $doc->PrintSumNal($_POST['sum_nal']);
    if (isset($_POST["sum_nal"]) && !empty($_POST["sum_nal"])) $doc->PrintSumNalStr(propis(floatval($_POST['sum_nal']), true));
    $doc->PrintShopPhone(normPhone($_POST['shop_phone']));
    $doc->PrintClientPhone(normPhone($_POST['client_phone']));
    $doc->PrintShopBankName($_POST['shop_bank_name']);
    $doc->PrintShopBankRs($_POST['shop_bank_rs']);
    $doc->PrintShopBankKs($_POST['shop_bank_ks']);
    $doc->PrintShopBankBik($_POST['shop_bank_bik']);
    $doc->PrintShopInn($_POST['shop_inn']);
    $doc->Output($file_name . ".pdf", I);
}

function print_blank112_a5()
{
    $file_name = fileName($_POST["blank_type"], $_POST['client_name'], $_POST['client_index']);
    $doc = new PDF_Blank112_a5('L', 'mm', 'A4');
    $doc->Open();
    $doc->PrintPage($file_name);
    $doc->PrintShopIndex($_POST['shop_index']);
    $doc->PrintClientIndex($_POST['client_index']);
    $doc->PrintClientName($_POST['client_name']);
    $doc->PrintShopName($_POST['shop_name']);
    $doc->PrintShopAddr($_POST['shop_addr']);
    $doc->PrintClientAddr($_POST['client_addr']);
    if (isset($_POST["sum_nal"]) && !empty($_POST["sum_nal"])) $doc->PrintSumNalStr($_POST['sum_nal']);
    $doc->PrintShopPhone(normPhone($_POST['shop_phone']));
    $doc->PrintClientPhone(normPhone($_POST['client_phone']));
    $doc->PrintShopBankName($_POST['shop_bank_name']);
    $doc->PrintShopBankRs($_POST['shop_bank_rs']);
    $doc->PrintShopBankKs($_POST['shop_bank_ks']);
    $doc->PrintShopBankBik($_POST['shop_bank_bik']);
    $doc->PrintShopInn($_POST['shop_inn']);
    $doc->Output($file_name . ".pdf", I);
}

function print_blank116($is_sec)
{
    $file_name = fileName($_POST["blank_type"], $_POST['client_name'], $_POST['client_index']);
    $doc = new PDF_Blank116('L', 'mm', 'A4');
    $doc->Open();
    $doc->PrintPage($file_name);
    $doc->PrintShopIndex($_POST['shop_index']);
    $doc->PrintClientIndex($_POST['client_index']);
    $doc->PrintClientName($_POST['client_name']);
    $doc->PrintShopName($_POST['shop_name']);
    $doc->PrintShopAddr($_POST['shop_addr']);
    $doc->PrintClientAddr($_POST['client_addr']);
    $doc->PrintSumOb($_POST['sum_ob']);
    $doc->PrintSumNal($_POST['sum_nal']);
    if (isset($_POST["sum_ob"]) && !empty($_POST["sum_ob"])) $doc->PrintSumObStr($_POST['sum_ob']);
    if (isset($_POST["sum_nal"]) && !empty($_POST["sum_nal"])) $doc->PrintSumNalStr($_POST['sum_nal']);
    $doc->PrintShopDocument($_POST["shop_document_name"], $_POST["shop_document_seria"], $_POST["shop_document_nomer"], $_POST["shop_document_datav"], $_POST["shop_document_kemv"]);
    if ($is_sec) $doc->PrintPage2();
    $doc->Output($file_name . ".pdf", I);
}

function print_blank116_origin()
{
    $file_name = fileName($_POST["blank_type"], $_POST['client_name'], $_POST['client_index']);
    $doc = new PDF_Blank116_origin('L', 'mm', 'A4');
    $doc->Open();
    $doc->PrintPage($file_name);
    $doc->PrintShopIndex($_POST['shop_index']);
    $doc->PrintClientIndex($_POST['client_index']);
    $doc->PrintClientName($_POST['client_name']);
    $doc->PrintShopName($_POST['shop_name']);
    $doc->PrintShopAddr($_POST['shop_addr']);
    $doc->PrintClientAddr($_POST['client_addr']);
    if (isset($_POST["sum_ob"]) && !empty($_POST["sum_ob"])) $doc->PrintSumObStr($_POST['sum_ob']);
    if (isset($_POST["sum_nal"]) && !empty($_POST["sum_nal"])) $doc->PrintSumNalStr($_POST['sum_nal']);
    $doc->PrintShopDocument($_POST["shop_document_name"], $_POST["shop_document_seria"], $_POST["shop_document_nomer"], $_POST["shop_document_datav"], $_POST["shop_document_kemv"]);
    $doc->PrintPage2();
    $doc->Output($file_name . ".pdf", I);
}

function print_blank116_2()
{
    $file_name = fileName($_POST["blank_type"], $_POST['client_name'], $_POST['client_index']);
    $doc = new PDF_Blank116_2('L', 'mm', 'A4');
    $doc->Open();
    $doc->PrintPage($file_name);
    $doc->PrintShopIndex($_POST['shop_index']);
    $doc->PrintClientIndex($_POST['client_index']);
    $doc->PrintClientName($_POST['client_name']);
    $doc->PrintShopName($_POST['shop_name']);
    $doc->PrintShopAddr($_POST['shop_addr']);
    $doc->PrintClientAddr($_POST['client_addr']);
    if (isset($_POST["sum_ob"]) && !empty($_POST["sum_ob"])) $doc->PrintSumObStr($_POST['sum_ob']);
    if (isset($_POST["sum_nal"]) && !empty($_POST["sum_nal"])) $doc->PrintSumNalStr($_POST['sum_nal']);
    $doc->PrintShopDocument($_POST["shop_document_name"], $_POST["shop_document_seria"], $_POST["shop_document_nomer"], $_POST["shop_document_datav"], $_POST["shop_document_kemv"]);
    $doc->PrintPage2();
    $doc->Output($file_name . ".pdf", I);
}

function print_opis107()
{
    $products = unserialize(str_replace("&@", " ", $_POST["products"]));
    for ($i = 0; $i < count($products); $i++) {
        $products[$i]['name'] = str_replace("ß", "b", $products[$i]['name']);
    }
    $file_name = fileName($_POST["blank_type"], $_POST['client_name'], $_POST['client_index']);
    $doc = new PDF_Opis107('L', 'mm', 'A4');
    $doc->Open();
    $doc->PrintPage($file_name);
    $doc->PrintGoods($_POST['client_name'], $_POST['client_index'], $_POST['client_addr'], $products, $_POST['sum_ob']);
    $doc->Output($file_name . ".pdf", I);
}

function print_blank7a()
{
    $file_name = fileName($_POST["blank_type"], $_POST['client_name'], $_POST['client_index']);
    $doc = new PDF_Blank7a('L', 'mm', 'A4');
    $doc->Open();
    $doc->PrintPage($file_name);
    $doc->PrintShopIndex($_POST['shop_index']);
    $doc->PrintClientIndex($_POST['client_index']);
    $doc->PrintClientName($_POST['client_name']);
    $doc->PrintShopName($_POST['shop_name']);
    $doc->PrintShopAddr($_POST['shop_addr']);
    $doc->PrintClientAddr($_POST['client_addr']);
    if (isset($_POST["sum_ob"]) && !empty($_POST["sum_ob"])) $doc->PrintSumObStr($_POST['sum_ob']);
    if (isset($_POST["sum_nal"]) && !empty($_POST["sum_nal"])) $doc->PrintSumNalStr($_POST['sum_nal']);
    $doc->Output($file_name . ".pdf", I);
}

function print_blank7b()
{
    $file_name = fileName($_POST["blank_type"], $_POST['client_name'], $_POST['client_index']);
    $doc = new PDF_Blank7b('L', 'mm', 'A4');
    $doc->Open();
    $doc->PrintPage($file_name);
    $doc->PrintShopIndex($_POST['shop_index']);
    $doc->PrintClientIndex($_POST['client_index']);
    $doc->PrintClientName($_POST['client_name']);
    $doc->PrintShopName($_POST['shop_name']);
    $doc->PrintShopAddr($_POST['shop_addr']);
    $doc->PrintClientAddr($_POST['client_addr']);
    if (isset($_POST["sum_ob"]) && !empty($_POST["sum_ob"])) $doc->PrintSumObStr($_POST['sum_ob'], !empty($_POST["sum_nal"]));
    if (isset($_POST["sum_nal"]) && !empty($_POST["sum_nal"])) $doc->PrintSumNalStr($_POST['sum_nal'], !empty($_POST["sum_nal"]));
    $doc->Output($file_name . ".pdf", I);
}

function print_blank7p()
{
    $file_name = fileName($_POST["blank_type"], $_POST['client_name'], $_POST['client_index']);
    $doc = new PDF_Blank7p('L', 'mm', 'A4');
    $doc->Open();
    $doc->PrintPage($file_name);
    $doc->PrintShopIndex($_POST['shop_index']);
    $doc->PrintClientIndex($_POST['client_index']);
    $doc->PrintClientName($_POST['client_name']);
    $doc->PrintShopName($_POST['shop_name']);
    $doc->PrintShopAddr($_POST['shop_addr']);
    $doc->PrintClientAddr($_POST['client_addr']);
    if (isset($_POST["sum_ob"]) && !empty($_POST["sum_ob"])) $doc->PrintSumObStr($_POST['sum_ob']);
    if (isset($_POST["sum_nal"]) && !empty($_POST["sum_nal"])) $doc->PrintSumNalStr($_POST['sum_nal']);
    $doc->Output($file_name . ".pdf", I);
}

function print_blank7p2()
{
    $file_name = fileName($_POST["blank_type"], $_POST['client_name'], $_POST['client_index']);
    $doc = new PDF_Blank7p2('L', 'mm', 'A4');
    $doc->Open();
    $doc->PrintPage($file_name);
    $doc->PrintShopIndex($_POST['shop_index']);
    $doc->PrintClientIndex($_POST['client_index']);
    $doc->PrintClientName($_POST['client_name']);
    $doc->PrintShopName($_POST['shop_name']);
    $doc->PrintShopAddr($_POST['shop_addr']);
    $doc->PrintClientAddr($_POST['client_addr']);
    if (isset($_POST["sum_ob"]) && !empty($_POST["sum_ob"])) $doc->PrintSumObStr($_POST['sum_ob']);
    if (isset($_POST["sum_nal"]) && !empty($_POST["sum_nal"])) $doc->PrintSumNalStr($_POST['sum_nal']);
    $doc->Output($file_name . ".pdf", I);
}

function print_blank112116()
{
    $file_name = fileName($_POST["blank_type"], $_POST['client_name'], $_POST['client_index']);
    $doc = new PDF_Blank112116('L', 'mm', 'A4');
    $doc->Open();
    $doc->PrintPage($file_name);
    $doc->PrintShopIndex($_POST['shop_index']);
    $doc->PrintClientIndex($_POST['client_index']);
    $doc->PrintClientName($_POST['client_name']);
    $doc->PrintShopName($_POST['shop_name']);
    $doc->PrintShopAddr($_POST['shop_addr']);
    $doc->PrintClientAddr($_POST['client_addr']);
    $doc->PrintShopDocument($_POST["shop_document_name"], $_POST["shop_document_seria"], $_POST["shop_document_nomer"], $_POST["shop_document_datav"], $_POST["shop_document_kemv"]);
    if (isset($_POST["sum_ob"]) && !empty($_POST["sum_ob"])) $doc->PrintSumObStr($_POST['sum_ob']);
    if (isset($_POST["sum_nal"]) && !empty($_POST["sum_nal"])) $doc->PrintSumNalStr($_POST['sum_nal']);
    $doc->PrintShopPhone(normPhone($_POST['shop_phone']));
    $doc->PrintClientPhone(normPhone($_POST['client_phone']));
    $doc->PrintShopBankName($_POST['shop_bank_name']);
    $doc->PrintShopBankRs($_POST['shop_bank_rs']);
    $doc->PrintShopBankKs($_POST['shop_bank_ks']);
    $doc->PrintShopBankBik($_POST['shop_bank_bik']);
    $doc->PrintShopInn($_POST['shop_inn']);
    $doc->Output($file_name . ".pdf", I);
}

function print_blankcn23()
{
    $goods = unserialize(str_replace("&@", " ", $_POST["products"]));
    $file_name = fileName($_POST["blank_type"], $_POST['client_name'], $_POST['client_index']);
    $doc = new PDF_Blankcn23('L', 'mm', 'A4');
    $doc->Open();
    $doc->PrintPage($file_name);
    $doc->PrintShopIndex($_POST['shop_index']);
    $doc->PrintClientPhone($_POST['client_phone']);
    $doc->PrintClientIndex($_POST['client_index']);
    $doc->PrintClientName($_POST['client_name'], 1);
    $doc->PrintShopName($_POST['shop_name'], isset($_POST["shop_document_name"]));
    $doc->PrintShopAddr($_POST['shop_addr']);
    $doc->PrintClientAddr($_POST['client_addr']);
    $doc->Output($file_name . ".pdf", I);
}

function print_blankfind()
{
    $file_name = fileName($_POST["blank_type"], $_POST['client_name'], $_POST['client_index']);
    $doc = new PDF_Blankfind('L', 'mm', 'A4');
    $doc->Open();
    $doc->PrintPage($file_name);
    $doc->PrintClient($_POST['client_name'], $_POST['client_addr'], $_POST['client_index']);
    $doc->PrintShop($_POST['shop_name'], $_POST['shop_addr'], $_POST['shop_index']);
    $doc->PrintShopDocument($_POST["shop_document_name"], $_POST["shop_document_seria"], $_POST["shop_document_nomer"], $_POST["shop_document_datav"], $_POST["shop_document_kemv"]);
    if (isset($_POST["sum_nal"]) && !empty($_POST["sum_nal"])) $doc->PrintSumOb($_POST['sum_nal']);
    if (isset($_POST["sum_ob"]) && !empty($_POST["sum_ob"])) $doc->PrintSumNal($_POST['sum_ob']);
    $doc->PrintShopPhone(normPhone($_POST['shop_phone']));
    $doc->Output($file_name . ".pdf", I);
}

function print_blankcp71()
{
    $goods = unserialize(str_replace("&@", " ", $_POST["products"]));
    $file_name = fileName($_POST["blank_type"], $_POST['client_name'], $_POST['client_index']);
    $doc = new PDF_Blankcp71('L', 'mm', 'A4');
    $doc->Open();
    $doc->PrintPage($file_name);
    $doc->PrintShopIndex($_POST['shop_index']);
    $doc->PrintClientPhone($_POST['client_phone']);
    $doc->PrintClientIndex($_POST['client_index']);
    $doc->PrintClientName($_POST['client_name'], 1);
    $doc->PrintShopName($_POST['shop_name'], isset($_POST["shop_document_name"]));
    $doc->PrintShopAddr($_POST['shop_addr']);
    $doc->PrintClientAddr($_POST['client_addr']);
    $doc->Output($file_name . ".pdf", I);
}

function mb_ucfirst($word)
{
    return mb_strtoupper(mb_substr($word, 0, 1, 'UTF-8'), 'UTF-8') . mb_substr(mb_convert_case($word, MB_CASE_LOWER, 'UTF-8'), 1, mb_strlen($word), 'UTF-8');
}

function propis($num, $r)
{
    $nul = 'ноль';
    $ten = array(array('', 'один', 'два', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять'), array('', 'одна', 'две', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять'),);
    $a20 = array('десять', 'одиннадцать', 'двенадцать', 'тринадцать', 'четырнадцать', 'пятнадцать', 'шестнадцать', 'семнадцать', 'восемнадцать', 'девятнадцать');
    $tens = array(2 => 'двадцать', 'тридцать', 'сорок', 'пятьдесят', 'шестьдесят', 'семьдесят', 'восемьдесят', 'девяносто');
    $hundred = array('', 'сто', 'двести', 'триста', 'четыреста', 'пятьсот', 'шестьсот', 'семьсот', 'восемьсот', 'девятьсот');
    $unit = array(array('копейка', 'копейки', 'копеек', 1), array('рубль', 'рубля', 'рублей', 0), array('тысяча', 'тысячи', 'тысяч', 1), array('миллион', 'миллиона', 'миллионов', 0), array('миллиард', 'милиарда', 'миллиардов', 0),);
    list($rub, $kop) = explode('.', sprintf("%015.2f", floatval($num)));
    $out = array();
    if (intval($rub) > 0) {
        foreach (str_split($rub, 3) as $uk => $v) {
            if (!intval($v)) continue;
            $uk = sizeof($unit) - $uk - 1;
            $gender = $unit[$uk][3];
            list($i1, $i2, $i3) = array_map('intval', str_split($v, 1));
            $out[] = $hundred[$i1];
            if ($i2 > 1) $out[] = $tens[$i2] . ' ' . $ten[$gender][$i3]; else $out[] = $i2 > 0 ? $a20[$i3] : $ten[$gender][$i3];
            if ($uk > 1) $out[] = morph($v, $unit[$uk][0], $unit[$uk][1], $unit[$uk][2]);
        }
    } else $out[] = $nul;
    if ($r) $out[] = morph(intval($rub), $unit[1][0], $unit[1][1], $unit[1][2]); else $out[] = morph(intval($rub), "", "", "");
    return mb_ucfirst(trim(preg_replace('/ {2,}/', ' ', join(' ', $out))));
}

function morph($n, $f1, $f2, $f5)
{
    $n = abs(intval($n)) % 100;
    if ($n > 10 && $n < 20) return $f5;
    $n = $n % 10;
    if ($n > 1 && $n < 5) return $f2;
    if ($n == 1) return $f1;
    return $f5;
}

function translit($str)
{
    $rus = array('А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я');
    $lat = array('A', 'B', 'V', 'G', 'D', 'E', 'E', 'Gh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'Ch', 'Sh', 'Sch', 'Y', 'Y', 'Y', 'E', 'Yu', 'Ya', 'a', 'b', 'v', 'g', 'd', 'e', 'e', 'gh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', 'y', 'y', 'y', 'e', 'yu', 'ya');
    return str_replace($rus, $lat, $str);
}

function fileName($type, $name, $index)
{
    $surname = translit(stristr($name, ' ', true));
    return $type . (!empty($surname) ? ("-" . $surname) : "") . (!empty($index) ? ("-" . $index) : "");
}

function startsWith($haystack, $needle)
{
    return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
}

function normPhone($phone)
{
    $phone = str_replace(array("(", ")", " ", "-"), "", $phone);
    return substr($phone, -10);
}

function tocp1251($str)
{
    return rtrim(iconv("utf-8", "windows-1251", $str));
}

function multiStr($str, $overn)
{
    $xs = translit($str);
    $res = array();
    foreach ($overn as $key => $value) {
        $x = substr($xs, 0, $value);
        if ($x != $xs) {
            $tr = strripos($x, "-") + 1;
            if (!$tr) {
                $n = strripos($x, " ");
            } else $n = max(strripos($x, " "), $tr);
            if ($n === false) {
                $r = substr($x, 0, $value) . "-";
                $xs = substr($xs, $value);
            } else {
                $r = substr($x, 0, $n);
                $xs = substr($xs, $n);
            }
            array_push($res, $r);
        }
    }
    array_push($res, $xs);
    return $res;
}

function error($error_message)
{
    header('Content-Type: text/html; charset=utf-8');
    echo($error_message);
} ?>