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

namespace FXMLRPC;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->serializer = $this->getMockBuilder('FXMLRPC\Serializer\SerializerInterface')
                                 ->getMock();
        $this->parser = $this->getMockBuilder('FXMLRPC\Parser\ParserInterface')
                             ->getMock();
        $this->transport = $this->getMockBuilder('FXMLRPC\Transport\TransportInterface')
                             ->getMock();

        $this->client = new Client('http://foo.com', $this->transport, $this->parser, $this->serializer);
    }

    public function testCallSerializer()
    {
        $this->serializer->expects($this->once())
                         ->method('serialize')
                         ->with('methodName', array('p1', 'p2'))
                         ->will($this->returnValue('REQUEST'));
        $this->transport->expects($this->once())
                        ->method('send')
                        ->with('http://foo.com', 'REQUEST')
                        ->will($this->returnValue('RESPONSE'));
        $this->parser->expects($this->once())
                     ->method('parse')
                     ->with('RESPONSE')
                     ->will($this->returnValue('NATIVE VALUE'));

        $this->assertSame('NATIVE VALUE', $this->client->call('methodName', array('p1', 'p2')));
    }
}