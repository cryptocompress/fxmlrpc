<?php
/**
 * Copyright (C) 2012
 * Lars Strojny, InterNations GmbH <lars.strojny@internations.org>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

namespace FXMLRPC\Transport;

use Guzzle\Http\Client;
use Guzzle\Http\Message\BadResponseException;
use Guzzle\Http\Exception\ServerErrorResponseException;
use Guzzle\Http\Curl\CurlException as CompatCurlException;
use Guzzle\Http\Exception\CurlException;
use FXMLRPC\Exception\HttpException;
use FXMLRPC\Exception\TcpException;

class GuzzleBridge implements TransportInterface
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function send($uri, $payload)
    {
        try {
            $response = $this->client->post($uri, null, $payload)
                                     ->send();
        } catch (CurlException $e) {
            throw new TcpException('A transport error occured', null, $e);
        } catch (CompatCurlException $e) {
            throw new TcpException('A transport error occured', null, $e);
        } catch (BadResponseException $e) {
            throw new HttpException(
                'An HTTP error occured: ' . $e->getMessage(),
                $e->getResponse()->getStatusCode(),
                $e
            );
        } catch (ServerErrorResponseException $e) {
            throw new HttpException(
                'An HTTP error occured: ' . $e->getMessage(),
                $e->getResponse()->getStatusCode(),
                $e
            );
        }

        return $response->getBody(true);
    }
}
