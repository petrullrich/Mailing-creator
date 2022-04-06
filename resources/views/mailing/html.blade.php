<div style="background-color:rgba(123, 205, 235, 0); font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;">
  
      <!--[if gte mso 9]>
    <v:background xmlns:v="urn:schemas-microsoft-com:vml" fill="t">
      <v:fill type="tile" src="https://indigoumi.cz/images/mailing_creator/themes/snow-min.png" color="#7bceeb"/>
    </v:background>
    <![endif]-->
    <table height="100%" width="100%" cellpadding="0" cellspacing="0" border="0">
    <tr>
    <td valign="top" align="left" background="{{ $mailing->theme->img_url }}" style="background-position: top;">     
        
    <div style=" margin: 0 auto; padding: 50px; {{ $mailing->theme->name == 'Výchozí' ? 'background: #2595be15' : '' }}">
        <table style="max-width: 760px;" align="center">
            <tbody>
                <tr>
                    <td>
                        @foreach ($products as $product)
                        <table class="product" style="margin: 10px; border-spacing: 0px; width: 230px; float: left; background: #ffffff; border: 1px solid #cccccc;" align="center" cellpadding="0" cellspacing="0" border="0">
                            <tbody style="border-spacing: 0;">
                                <tr style="">
                                    <td>
                                        <a href="{{ $product->url }}">
                                            <div class="image-box" style="height: 200px; padding: 0; text-align: center; overflow: hidden; border-bottom: 1px solid #cccccc; background-image:linear-gradient(rgb(255, 255, 255),rgb(255, 255, 255));">
                                                <div style="padding: 0; display: inline-block; height:100%; vertical-align:middle;">
                                                    <div style="display: inline-block; height:100%; vertical-align:middle;"></div>
                                                    @php
                                                        $size = [1,1];
                                                        if ($product->img_url) {
                                                            $size = getimagesize($product->img_url);
                                                        }
                                                    @endphp
                                                    @if ($size[0] > $size[1])
                                                        <img src="{{ $product->img_url }}" alt="" height="auto" width="160px" style="width: 160px; height: auto; vertical-align: middle;">
                                                    @else
                                                        <img src="{{ $product->img_url }}" alt="" height="160" width="auto" style=" width: auto; height: 160px; vertical-align: middle;">
                                                    @endif
                                                </div>
                                            </div>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div style="width:228px; height: 65px; overflow: hidden; ">
                                            <p style="font-weight: bold; font-size: 15px; line-height: 1.2; padding: 10px; margin: 0;">{{ $product->name }}</p>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="">
                                        <div style="height: 75px; overflow: hidden; line-height: 1.2; font-size: 13px;">
                                            <p style="padding: 10px 10px 0 10px; margin: 0;">{{  \Illuminate\Support\Str::limit($product->description, 110, $end='...') }}</p>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <table id="price" style="width: 100%;">
                                            <tbody>
                                                <tr>
                                                    <td style="padding: 10px;">
                                                        <p style="color: red; font-weight: bold; font-size: 24px; margin: 0;">{{ number_format($product->price, 0, "", " ") }} Kč</p>
                                                    </td>
                                                    <td style="padding: 10px;">
                                                        <span id="old-price" style="text-decoration: line-through">
                                                            <p style="color: #12226c; font-weight: normal; font-size: 15px; margin: 0;">
                                                                {{ $product->old_price == 0 ? "" : number_format($product->old_price, 0, "", " ")."Kč" }}
                                                            </p>
                                                        </span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <table id="price" style="width: 100%; border-top: 1px solid #e2e2e2;  height: 66px;">
                                            <tbody>
                                                <tr>
                                                    <td style="padding: 14px 10px 14px 10px;">
                                                        <a href="{{ $product->url }}" style="text-decoration: none;">
                                                            <div style="padding: 8px 12px; background: #12226c; display: inline;">
                                                                <span style="color: white; font-weight: bold; ">Zobrazit</span>
                                                            </div>
                                                        </a>
                                                    </td>
                                                    
                                                    <td style="padding: 10px; text-align: right;">
                                                        <div>
                                                            @php
                                                                $size = [1,1];
                                                                if (optional($product->manufacturer)->image) {
                                                                    
                                                                    $size = getimagesize($product->manufacturer->image);
                                                                }
                                                            @endphp
                                                            @if (($size[0]/$size[1]) > 2)
                                                                <img src="{{ optional($product->manufacturer)->image }}" alt="" height="46px" width="auto" style="width: 90px; height: auto; vertical-align: middle;">
                                                            @else
                                                                <img src="{{ optional($product->manufacturer)->image }}" alt="" height="46px" width="auto" style="width: auto; height: 45px; vertical-align: middle;">
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        @endforeach
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</td>
</tr>
</table>
</div>