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

namespace FXMLRPC\Parser;

use DateTime;
use DateTimeZone;

class XMLReaderParserTest extends AbstractParserTest
{
    public function setUp()
    {
        if (!extension_loaded('xmlreader')) {
            $this->markTestSkipped('ext/xmlreader not available');
        }

        $this->parser = new XMLReaderParser();
    }

    public function testApacheI1ExtensionValue()
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>
            <methodResponse xmlns:ext="http://ws.apache.org/xmlrpc/namespaces/extensions">
                <params>
                    <param>
                        <value>
                            <ext:i1>1</ext:i1>
                        </value>
                    </param>
                </params>
            </methodResponse>';

        $this->assertSame(1, $this->parser->parse($xml, $isFault));
        $this->assertFalse($isFault);
    }

    public function testApacheI2ExtensionValue()
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>
            <methodResponse xmlns:ext="http://ws.apache.org/xmlrpc/namespaces/extensions">
                <params>
                    <param>
                        <value>
                            <ext:i2>1</ext:i2>
                        </value>
                    </param>
                </params>
            </methodResponse>';

        $this->assertSame(1, $this->parser->parse($xml, $isFault));
        $this->assertFalse($isFault);
    }

    public function testApacheI8ExtensionValue()
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>
            <methodResponse xmlns:ext="http://ws.apache.org/xmlrpc/namespaces/extensions">
                <params>
                    <param>
                        <value>
                            <ext:i8>9223372036854775808</ext:i8>
                        </value>
                    </param>
                </params>
            </methodResponse>';

        $this->assertSame('9223372036854775808', $this->parser->parse($xml, $isFault));
        $this->assertFalse($isFault);
    }

    public function testApacheBigIntegerExtensionValue()
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>
            <methodResponse xmlns:ext="http://ws.apache.org/xmlrpc/namespaces/extensions">
                <params>
                    <param>
                        <value>
                            <ext:biginteger>9223372036854775808</ext:biginteger>
                        </value>
                    </param>
                </params>
            </methodResponse>';

        $this->assertSame('9223372036854775808', $this->parser->parse($xml, $isFault));
        $this->assertFalse($isFault);
    }

    public function testApacheBigDecimalExtensionValue()
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>
            <methodResponse xmlns:ext="http://ws.apache.org/xmlrpc/namespaces/extensions">
                <params>
                    <param>
                        <value>
                            <ext:bigdecimal>-100000000000000000.1234</ext:bigdecimal>
                        </value>
                    </param>
                </params>
            </methodResponse>';

        $this->assertSame(-100000000000000000.1234, $this->parser->parse($xml, $isFault));
        $this->assertFalse($isFault);
    }

    public function testApacheFloatlExtensionValue()
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>
            <methodResponse xmlns:ext="http://ws.apache.org/xmlrpc/namespaces/extensions">
                <params>
                    <param>
                        <value>
                            <ext:float>-100000000000000000.1234</ext:float>
                        </value>
                    </param>
                </params>
            </methodResponse>';

        $this->assertSame(-100000000000000000.1234, $this->parser->parse($xml, $isFault));
        $this->assertFalse($isFault);
    }
}
