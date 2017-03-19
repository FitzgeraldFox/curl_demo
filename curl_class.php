<?php
/**
 * Методы обработки Curl-запроса.
 */
class CURL {
    /**
     * Объект Curl-запроса.
     */
    private $request;
    /**
     * Конструктор класса CURL.
     *
     * @throws Exception, если при инициализации возникли ошибки.
     */
    public function __construct()
    {
        $this->request = curl_init();
        $this->throwExceptionIfError($this->request);
    }
    /**
     * Настройка Curl -запроса.
     *
     * @param $url Целевой url-адрес.
     * @param $urlParameters Массив параметров в формате "key" => "value".
     * @param $method "GET" или "POST"; по умолчанию - "GET".
     * @param $moreOptions Другие параметры, добавляемые к Curl -запросу.
     * По умолчанию задано "CURLOPT_FOLLOWLOCATION"(переходить по редиректам 3XX) и "CURLOPT_RETURNTRANSFER"
     * (возвращает ответ HTTP в качестве значения, вместо вывода напрямую).
     * @throws Exception, если возникли ошибки при настройке.
     */
    public function configure($url, $urlParameters = [], $method = "GET",
      $moreOptions = [CURLOPT_FOLLOWLOCATION => true, CURLOPT_RETURNTRANSFER => true])
    {
        curl_reset($this->request); //Эта функция переинициализирует все настройки заданного обработчика сессии cURL значениями по умолчанию.
        switch ($method) {
            case "GET":
                $options = [CURLOPT_URL => $url . $this->stringifyParameters($urlParameters)];
                break;
            case "POST":
                $options = [
                  CURLOPT_URL => $url,
                  CURLOPT_POST => true,
                  CURLOPT_POSTFIELDS => $this->stringifyParameters($urlParameters)
                ];
                break;
            default:
                throw new Exception("Method must be GET or POST");
                break;
        }
        $options = $options + $moreOptions;
        curl_setopt_array($this->request, $options);
    }
    /**
     * Выполняем Curl-запрос в соответствии с параметрами конфигурации.
     *
     * @return возвращает значение функции curl_exec(). Если настроен CURLOPT_RETURNTRANSFER,
     *     возвращаемое значение будет ответом HTTP. В противном случае, значение true (или false,
     *     если возникла ошибка).
     * @throws Exception, если возникла ошибка при исполнении.
     */
    public function execute()
    {
        $result = curl_exec($this->request);
        $this->throwExceptionIfError($result);
        return $result;
    }
    /**
     * Закрываем сессию Curl.
     */
    public function close() {
        curl_close($this->request);
    }
    /**
     * Проверяем, вернули ли функции curl_* штатное значение или ошибку, добавляя исключение
     * с сообщением об ошибке Curl в случае возникновения ошибки.
     *
     * @param $success была ли функция curl выполнена успешно или нет.
     * @throws Exception, если функция curl не выполнена.
     */
    protected function throwExceptionIfError($success) {
        if (!$success) {
            throw new Exception(curl_error($this->request));
        }
    }
    /**
     * Составляем строку параметров GET.
     *
     * @param $parameters массив параметров.
     * @return Parameters в формате строки: "?key1=value1&key2=value2"
     */
    protected function stringifyParameters($parameters) {
        $parameterString = "?";
        foreach ($parameters as $key => $value) {
            $key = urlencode($key);
            $value = urlencode($value);
            $parameterString .= "$key=$value&";
        }
        rtrim($parameterString, "&");
        return $parameterString;
    }
}