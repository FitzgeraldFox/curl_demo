<?php

class Curl
{
    /** @var resource cURL handle */
    private $request;

    /** @var mixed The response */
    private $response = false;

    /**
     * @param string $url
     * @param array  $options
     */
    public function __construct($url, array $options = array())
    {
        $this->request = curl_init($url);
        curl_setopt_array($this->request, $options);
    }

    /**
     * Get the response
     * @return string
     * @throws \RuntimeException On cURL error
     */
    public function getResponse()
    {
        if ($this->response) {
            return $this->response;
        }

        $response = curl_exec($this->request);
        $error    = curl_error($this->request);
        $errno    = curl_errno($this->request);

        if (is_resource($this->request)) {
            curl_close($this->request);
        }

        if (0 !== $errno) {
            throw new \RuntimeException($error, $errno);
        }

        return $this->response = $response;
    }

    /**
     * Let echo out the response
     * @return string
     */
    public function __toString()
    {
        return $this->getResponse();
    }
}

// usage
$curl = new Curl('ftp://ftp.gnu.org', array(
  CURLOPT_FTPLISTONLY => true,
  CURLOPT_USERPWD => "anonymous:andrey.xwz@mail.ru",
  CURLOPT_RETURNTRANSFER => true
));

try {
    echo $curl;
} catch (\RuntimeException $ex) {
    die(sprintf('Http error %s with code %d', $ex->getMessage(), $ex->getCode()));
}