<?php
// agent 判別

class Agent
{
// docomo, jphone, ezweb, astel, pdx, win, mac, linux
  var $carrier = "pc"; // デフォルトは pc
  var $HTTP_USER_AGENT;
  var $HTTP_ACCEPT;
  var $PC_OS = false;

// コンストラクタ
  function agent()
  {
    $this->HTTP_USER_AGENT = getenv("HTTP_USER_AGENT");
    $this->HTTP_ACCEPT = getenv("HTTP_ACCEPT");

  // J-Phone用
    $HTTP_X_JPHONE_MSNAME = getenv("HTTP_X_JPHONE_MSNAME");

    if ($HTTP_X_JPHONE_MSNAME)
    {
    // J-Phone時代の
      $this->carrier = "s";
    }
    elseif (preg_match("/^Vodafone/i", $this->HTTP_USER_AGENT) || preg_match("/^MOT/i", $this->HTTP_ACCEPT))
    {
    // Softbank(Vodafone)
      $this->carrier = "s";
    }
    elseif (preg_match("/up\.browser/i", $this->HTTP_USER_AGENT) || preg_match("/\Whdml/i", $this->HTTP_ACCEPT))
    {
    // EZweb
      $this->carrier = "ez";
    }
    elseif (preg_match("#^docomo/#i", $this->HTTP_USER_AGENT))
    {
    // Docomo
      $this->carrier = "i";
    }
    elseif (preg_match("#^astel/#i", $this->HTTP_USER_AGENT))
    {
    // Astel
      $this->carrier = "i";
    }
    elseif (preg_match("#^pdxgw/#i", $this->HTTP_USER_AGENT))
    {
    // H"
      $this->carrier = "i";
    }
    else
    {
    // その他はPC
      $this->carrier = "pc";

      $this->PC_OS = $this->pc_os();
    }
  }

// Ezwebデバイス取得
  function ezwebDevice()
  {
	$ua = $this->HTTP_USER_AGENT;

	if (strpos($ua, 'KDDI') === 0) {
		// WAP2.0ブラウザ搭載端末
		$ary = explode('-', $ua);
		$ary = explode(' ', $ary[1]);
		$did = $ary[0];
	} else {
		// HDMLブラウザ搭載端末
		$ary = explode('-', $ua);
		$ary = explode(' ', $ary[1]);
		$did = $ary[0];
	}
	return $did;
  }

// 端末の種別を返す
  function carrier()
  {
    return $this->carrier;
  }

// pcのOS判別
  function pc_os()
  {
    if (preg_match("/win/i", $this->HTTP_USER_AGENT))
    {
    // Windows
      return "win";
    }
    elseif (preg_match("/mac/i", $this->HTTP_USER_AGENT))
    {
    // Macintosh
      return "mac";
    }
    elseif (preg_match("/linux/i", $this->HTTP_USER_AGENT))
    {
    // Linux
      return "linux";
    }
    elseif (preg_match("/AVE-Front/i", $this->HTTP_USER_AGENT))
    {
    // PDA
      return "pda";
    }
    elseif (preg_match("/Xiino/i", $this->HTTP_USER_AGENT))
    {
      return "pda";
    }
    elseif (preg_match("/^sharp/i", $this->HTTP_USER_AGENT))
    {
      return "pda";
    }
    else
    {
    // Unknown
      return false;
    }
  }

/* ezweb 用メソッド */
// 動画端末判定
  function is_movie()
  {
    if ($this->carrier == "ez")
    {
    // EZwebのときは動画端末用の変数をチェックする
      $HTTP_X_UP_DEVCAP_MULTIMEDIA = getenv("HTTP_X_UP_DEVCAP_MULTIMEDIA");

    // 動画端末用環境変数の有無を判定する
      if ($this->is_wap2())
      {
        if (ereg("^1", $HTTP_X_UP_DEVCAP_MULTIMEDIA))
        {
          return true;
        }

        return false;
      }
    // それ以外は非対応端末
      else
      {
        return false;
      }
    }
    else
    {
    // 他端末は不明
      return false;
    }
  }

// WAP 2.0判定
  function is_wap2()
  {
    if ($this->carrier == "ez")
    {
      $HTTP_X_UP_DEVCAP_MULTIMEDIA = getenv("HTTP_X_UP_DEVCAP_MULTIMEDIA");

      if (preg_match("/^OPWV\-GEN\-99.+UNI10/i", $this->HTTP_USER_AGENT))
      {
      // OPENWAVE Emulator
        return true;
      }
    // WAP2.0用環境変数の有無を判定する
      elseif ($HTTP_X_UP_DEVCAP_MULTIMEDIA)
      {
      // 対応端末です！
        return true;
      }
      else
      {
      // 非対応端末です
        return false;
      }
    }
    else
    {
    // 他端末は不明
      return false;
    }
  }

// FOMA判定
  function is_foma()
  {
    global $HTTP_USER_AGENT;

    if ($this->carrier == "i")
    {
      if (preg_match("/^DoCoMo\/2.0/i", $HTTP_USER_AGENT))
      {
        return true;
      }
    }

    return false;
  }

// サブスクライバIDゲット
  function subscribe_id()
  {
    global $HTTP_USER_AGENT;

    if ($this->carrier == "ez")
    {
      global $HTTP_X_UP_SUBNO;

      return $HTTP_X_UP_SUBNO;
    }
    elseif ($this->carrier() == "i")
    {
    // DoCoMoは送信を許可しないと送信されないので注意
      if ($this->is_foma())
      {
      // FOMA
        preg_match("/ser(\S{15})/i", $HTTP_USER_AGENT, $subid);

        return $subid[1];
      }
      else
      {
      // 従来機種
        preg_match("/ser(\S{11})/i",$HTTP_USER_AGENT, $subid);

        return $subid[1];
      }
    }
    elseif ($this->carrier() == "s")
    {
      preg_match("/\/SN(\S+)\s/i", $HTTP_USER_AGENT, $subid);

      return $subid[1];
    }
    else
    {
    // 他端末は不明
      return false;
    }
  }

// 機種情報ゲット
  function phone_type()
  {
    global $HTTP_USER_AGENT;

    if ($this->carrier() == "ez")
    {
      if ($this->is_wap2())
      {
        if (preg_match("/^KDDI\-(\S+)\sUP\.Browser.*/i", $HTTP_USER_AGENT, $type))
        {
          return $type[1];
        }
        elseif (preg_match("/^OPWV-GEN-99/i", $HTTP_USER_AGENT))
        {
          return "OpenwaveSymulator WAP2.0";
        }
      }
      else
      {
        if (preg_match("/^UP\.Browser\/\d+\.\d+\-(\S+)\s.*/i", $HTTP_USER_AGENT, $type))
        {
          return $type[1];
        }
        elseif (preg_match("/HTTP\-DIRECT$/i", $HTTP_USER_AGENT))
        {
          return "OpenwaveSymulator HDML";
        }
      }
    }
    elseif ($this->carrier() == "i")
    {
      if (preg_match("/^DoCoMo\/2.0\s([^\/\s]+)/i", $HTTP_USER_AGENT, $type))
      {
      // FOMA
        return $type[1];
      }
      elseif (preg_match("/^DoCoMo\/1.0\/([^\/\s]+)/i", $HTTP_USER_AGENT, $type))
      {
      // 従来端末
        return $type[1];
      }
    }
    elseif ($this->carrier() == "s")
    {
      if (preg_match("/^J\-PHONE\/[\d\.]+\/([^\/\s]+)/i", $HTTP_USER_AGENT, $type))
      {
        return $type[1];
      }
    }
    elseif ($this->carrier() == "i")
    {
      if (preg_match("/^ASTEL\/[\d\.]+\/([^\/\s]+)/i", $HTTP_USER_AGENT, $type))
      {
        return $type[1];
      }
    }
    elseif ($this->carrier() == "pc")
    {
      if (preg_match("/(Win[^;\)]+|Mac[^;\)]+|Linux\s[^;\)\s]+|sharp\spda|AVE[^;\)\s]+|xiino[^;\)\s]+)/i", $HTTP_USER_AGENT, $type))
      {
        return $type[1];
      }
    }

    return false;
  }

// ユーザのIP Addressゲット
  function ip_address()
  {
    global $REMOTE_HOST;
    global $REMOTE_ADDR;

  // ホスト名またはIPアドレスを得る
    if ($REMOTE_HOST)
    {
      $hostname = $REMOTE_HOST;
    }
    else
    {
      $hostname = $REMOTE_ADDR;
    }

  // IPアドレスに変換
    if (preg_match("/^(\d+)\.(\d+)\.(\d+)\.(\d+)\D*.*/", $hostname, $parts))
    {
      $ip_address = $parts[1] . "." . $parts[2] . "." . $parts[3] . "." . $parts[4];
    }
    else
    {
      $ip_address = gethostbyname($hostname);
    }

    if ($ip_address)
    {
      return $ip_address;
    }
    else
    {
      return false;
    }
  }

// ホスト名を得る
  function host_name()
  {
    $ip_address = $this->ip_address();

    if ($ip_address)
    {
      $hostname = gethostbyaddr($ip_address);

      return $hostname;
    }
    else
    {
      return false;
    }
  }

// proxy
  function proxy()
  {
    global $HTTP_VIA;
    global $HTTP_FORWARDED;
    global $HTTP_X_FORWARDED_FOR;

  // 漏れ串チェック
    if ($HTTP_VIA)
    {
      if (preg_match("/.*\s(\d+)\.(\d+)\.(\d+)\.(\d+)/", $HTTP_VIA, $proxy))
      {
        return $proxy[1] . "." . $proxy[2] . "." . $proxy[3] . "." . $proxy[4];
      }
    }

    if ($HTTP_FORWARDED)
    {
      if (preg_match("/.*\s(\d+)\.(\d+)\.(\d+)\.(\d+)/", $HTTP_FORWARDED, $proxy))
      {
        return $proxy[1] . "." . $proxy[2] . "." . $proxy[3] . "." . $proxy[4];
      }
    }

    if ($HTTP_X_FORWARDED_FOR)
    {
      if (preg_match("/.*\s(\d+)\.(\d+)\.(\d+)\.(\d+)/", $HTTP_X_FORWARDED_FOR, $proxy))
      {
        return $proxy[1] . "." . $proxy[2] . "." . $proxy[3] . "." . $proxy[4];
      }
    }

    return false;
  }

// 位置情報
  function location()
  {
    if ($this->carrier() == "s")
    {
      global $HTTP_X_JPHONE_GEOCODE;

      $x_jphone_geocode = urldecode($HTTP_X_JPHONE_GEOCODE);

    // 間に何か不明なデータが入っているので .* が必要!!
      preg_match("/^(\d{2})(\d{2})(\d{2}).*(\d{3})(\d{2})(\d{2})(.+)/", $x_jphone_geocode, $geocode);

      array_shift($geocode);

      return $geocode;
    }
  }
}
?>
