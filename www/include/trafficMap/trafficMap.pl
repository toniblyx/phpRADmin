#!/usr/bin/perl
# Network Wearthermap - version 1.1.1 (20040422)
# http://netmon.grnet.gr/weathermap/
# Panagiotis Christias, <christias@noc.ntua.gr>

$VERSION = "1.1.1";

use Getopt::Long;
use GD;

################################################################
#
# Configuration parameters
#
$WGET   = "/usr/bin/wget -qO -";
$CONFIG = "./include/trafficMap/conf/trafficMap.conf".$ARGV[0].".php";
$OUTPUT = "./include/trafficMap/png/trafficMap".$ARGV[0].".png";
$DEBUG  = 0;
$WIDTH  = $ARGV[1];
$HEIGHT = $ARGV[2];
$tempLink;
#
################################################################

%optctl=();
GetOptions(\%optctl, "config:s", "output:s", "version", "help", "debug", "") || exit(1);

if($optctl{"config"}) { $CONFIG = $optctl{"config"} };

if($optctl{"output"}) { $OUTPUT = $optctl{"output"} };

if($optctl{"version"}) { &version; exit; }

if($optctl{"help"}) { &usage; exit; }

if($optctl{"debug"}) { $DEBUG=1; }

&read_config($CONFIG);

if($background){
    open (PNG,"$background") || die "$background: $!\n";
    $map = newFromPng GD::Image(PNG) || die "newFromPng failed.";
    close PNG;
} else {
    $map=new GD::Image($WIDTH,$HEIGHT)
}

&alloc_colors;

print "<br><br>Opening log files...\n\n" if($DEBUG);
foreach $link (keys %target){

    $data = $target{$link};
    print "<br>FILE: $data\n<br>" if($DEBUG);

    if(($data =~ /^https?:\/\//i) || ($data =~ /^ftp:\/\//i) ) {
        open(LOG, "$WGET $data |") or warn "<br>$data: $!\n";
    } else {
        open(LOG, "$data") or warn "<br>data file $data: $!\n";
    }

    while(<LOG>){
        # <!-- cuin d 5585966 -->
        # <!-- cuout d 10589424 -->
        if(/<\!-- cuin d [\-]*(\d+) -->/){
            $input{$link}=abs($1);
            print "<br>LINK: $link, Input: $input{$link}\n" if($DEBUG);
        }
        if(/<\!-- cuout d [\-]*(\d+) -->/){
            $output{$link}=abs($1);
            print "<br>LINK: $link, Output: $output{$link}\n" if($DEBUG);
        }
    }
    close(LOG);
}

print "<br>\nCalculating rates...\n\n" if($DEBUG);

foreach $link (keys %target){
        $outrate=(int(($output{$link}/$maxbytesOut{$link}+0.005)*100)>100) ? 100:int(($output{$link}/$maxbytesOut{$link}+0.005)*100);
    $inrate=(int(($input{$link}/$maxbytesIn{$link}+0.005)*100)>100) ? 100:int(($input{$link}/$maxbytesIn{$link}+0.005)*100);

    if($output{$link} != 0 && $outrate == 0) { $outrate=1 }
    if($input{$link} != 0 && $inrate == 0) { $inrate=1 }

    print "<br>$target{$link}: outrate=$outrate%, inrate=$inrate%\n" if($DEBUG);

    # draw lines...

    $width=4;

    &draw_arrow(
        $xpos{$nodea{$link}},
        $ypos{$nodea{$link}},
        &middle($xpos{$nodea{$link}},$xpos{$nodeb{$link}}),
        &middle($ypos{$nodea{$link}},$ypos{$nodeb{$link}}),
        $width, 1, &select_color($outrate));
    &draw_arrow(
        $xpos{$nodea{$link}},
        $ypos{$nodea{$link}},
        &middle($xpos{$nodea{$link}},$xpos{$nodeb{$link}}),
        &middle($ypos{$nodea{$link}},$ypos{$nodeb{$link}}),
        $width, 0, $black);

    &label(&middle($xpos{$nodea{$link}},&middle($xpos{$nodea{$link}},$xpos{$nodeb{$link}})),
        &middle($ypos{$nodea{$link}},&middle($ypos{$nodea{$link}},$ypos{$nodeb{$link}})),
        $outrate . "%", 0);

    &draw_arrow(
        $xpos{$nodeb{$link}},
        $ypos{$nodeb{$link}},
        &middle($xpos{$nodea{$link}},$xpos{$nodeb{$link}}),
        &middle($ypos{$nodea{$link}},$ypos{$nodeb{$link}}),
        $width, 1, &select_color($inrate));
    &draw_arrow(
        $xpos{$nodeb{$link}},
        $ypos{$nodeb{$link}},
        &middle($xpos{$nodea{$link}},$xpos{$nodeb{$link}}),
        &middle($ypos{$nodea{$link}},$ypos{$nodeb{$link}}),
        $width, 0, $black);

    &label(&middle($xpos{$nodeb{$link}},&middle($xpos{$nodea{$link}},$xpos{$nodeb{$link}})),
        &middle($ypos{$nodeb{$link}},&middle($ypos{$nodea{$link}},$ypos{$nodeb{$link}})),
        $inrate . "%", 0);
}

foreach(keys %xpos){

    if (!exists($tempLink{$label{$_}})){
    &label($xpos{$_},$ypos{$_},$label{$_}, 3);
    }

    $tempLink[$label{$_}][0] = $xpos{$_};
    $tempLink[$label{$_}][1] = $ypos{$_};
}


print "<br>\n" if($DEBUG);

&annotation;

# print image...
print "<br>Generating image file $OUTPUT...\n\n" if($DEBUG);
open(PNG,">$OUTPUT")||die("$OUTPUT: $!\n");
binmode PNG;
print PNG $map->png;
close PNG;

# hint, resizing the image could make it look better

exit;


# print labels
sub label{
    my($xpos,$ypos,$label,$pad)=@_;
    my($strwidth)=gdSmallFont->width*length($label);
    my($strheight)=gdSmallFont->height;
    $map->filledRectangle(
        $xpos-$strwidth/2-$pad-2, $ypos-$strheight/2-$pad+1,
        $xpos+$strwidth/2+$pad+1, $ypos+$strheight/2+$pad,
        $black);
    $map->filledRectangle(
        $xpos-$strwidth/2-$pad-1, $ypos-$strheight/2-$pad+2,
        $xpos+$strwidth/2+$pad, $ypos+$strheight/2+$pad-1,
        $white);
    $map->string(gdSmallFont,
        $xpos-$strwidth/2, $ypos-$strheight/2+1,
        $label, $black)
}


# print annotation
sub annotation{
    my($title)="Traffic load";
        $strwidth=gdSmallFont->width*length($label{$_});
    $strheight=gdSmallFont->height;

 #  $t=localtime(time);
 #  $t=gmtime(time);
 #  $map->string(gdSmallFont, 0, 0, "Last update on $t UTC", $black);

    $map->filledRectangle($keyxpos,$keyypos,
        $keyxpos+gdSmallFont->width*length($title)+10,
        $keyypos+gdSmallFont->height*($scales+1)+10,
        $gray);
    $map->rectangle($keyxpos,$keyypos,
        $keyxpos+gdSmallFont->width*length($title)+10,
        $keyypos+gdSmallFont->height*($scales+1)+10,
        $black);
    $map->string(gdSmallFont,
        $keyxpos+4,
        $keyypos+4,
        "Traffic load",  $black);

    my($i)=1;
    foreach(sort {$scale_low{$a}<=>$scale_low{$b}} keys %scale_low){
        $map->filledRectangle(
            $keyxpos+6,
            $keyypos+gdSmallFont->height*$i+8,
            $keyxpos+6+16,
            $keyypos+gdSmallFont->height*$i+gdSmallFont->height+6,
            $color{$_});
        $map->string(gdSmallFont,
            $keyxpos+6+20,
            $keyypos+gdSmallFont->height*$i+8,
            "$scale_low{$_}-$scale_high{$_}%", $black);
        $i++
    }
}

sub select_color {
    my($rate)=($_[0]>100) ? 100:$_[0];
    if($rate=="0"){return($darkgray)}
    foreach(sort {$scale_high{$a}<=>$scale_high{$b}} keys %scale_high){
        if($scale_low{$_}<=$rate && $rate<=$scale_high{$_}){
            return($color{$_});
        }
    }
}

sub alloc_colors {
    $white=$map->colorAllocate(255,255,255);
    $gray=$map->colorAllocate(248,248,248);
    $black=$map->colorAllocate(0,0,0);
    $darkgray=$map->colorAllocate(128,128,128);

    foreach(keys %scale_red){
        $color{$_} = $map->colorAllocate($scale_red{$_},$scale_green{$_},$scale_blue{$_});
    }
}


sub read_config {
my($config)=shift;
my($node,$link);

print "<br>\nReading configuration file... $config\n\n" if($DEBUG);

$scales=0;
open(CONF,$config) or die "$config: $!\n";
while(<CONF>){
    if(/^\s*BACKGROUND\s+(\S+)/i){
        if(-s "$1"){
            $background=$1;
            print "<br>found BACKGROUND: $background\n" if($DEBUG);
        }
    }
    if(/^\s*WIDTH\s+(\d+)/i){
        if("$1" ne ""){
            $WIDTH=$1;
            print "<br>found WIDTH: $WIDTH\n" if($DEBUG);
        }
    }
    if(/^\s*HEIGHT\s+(\d+)/i){
        if("$1" ne ""){
            $HEIGHT=$1;
            print "<br>found HEIGHT: $HEIGHT\n" if($DEBUG);
        }
    }
    if(/^\s*NODE\s+(\S+)/i){
        $node=$1;
        print "<br>found NODE: $node\n" if($DEBUG);
    }
    if(/^\s*POSITION\s+(\d+)\s+(\d+)/i){
        $xpos{$node}=$1;
        $ypos{$node}=$2;
        print "<br>found NODE: $node XPOS: $xpos{$node} YPOS: $xpos{$node}\n" if($DEBUG);
    }
    if(/^\s*LABEL\s+([\ \w_\.]+)/i){
        $label{$node}=$1;
        print "<br>found NODE: $node LABEL: $label{$node}\n" if($DEBUG);
    }

    if(/^\s*LINK\s+(\S+)/i){
        $link=$1;
        print "<br>found LINK: $link\n" if($DEBUG);
    }
    if(/^\s*NODES\s+(\S+)\s+(\S+)/i){
        $nodea{$link}=$1;
        $nodeb{$link}=$2;
        print "<br>found LINK: $link NODEA: $nodea{$link} NODEB: $nodeb{$link}\n" if($DEBUG);
    }
    if(/^\s*TARGET\s+(\S+)/i){
        $target{$link}=$1;
        print "<br>found LINK: $link TARGET: $target{$link}\n" if($DEBUG);
    }
    if(/^\s*BANDWIDTH_IN\s+(\d+)/i){
        $bandwidthIn{$link}=$1;
        $maxbytesIn{$link}=$bandwidthIn{$link}*1024/8;
        print "<br>found LINK: $link BANDWIDTH_IN: $bandwidthIn{$link}\n" if($DEBUG);
    }
        if(/^\s*BANDWIDTH_OUT\s+(\d+)/i){
        $bandwidthOut{$link}=$1;
        $maxbytesOut{$link}=$bandwidthOut{$link}*1024/8;
        print "<br>found LINK: $link BANDWIDTH_OUT: $bandwidthOut{$link}\n" if($DEBUG);
        }
    if(/^\s*KEYPOS\s+(\d+)\s+(\d+)/i){
        $keyxpos=$1;
        $keyypos=$2;
        print "<br>found KEY POSITION: $keyxpos $keyypos\n" if($DEBUG);
    }
    if(/^\s*SCALE\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)/i){
        $scale_low{"$1:$2"}=$1;
        $scale_high{"$1:$2"}=$2;
        $scale_red{"$1:$2"}=$3;
        $scale_green{"$1:$2"}=$4;
        $scale_blue{"$1:$2"}=$5;
        $scales++;
        print "<br>found SCALE DATA: $1:$2 $3:$4:$5\n" if($DEBUG);
    }
}
print "<br>\n" if($DEBUG);
}


sub middle{
    return int( $_[0] + ($_[1]-$_[0])/2 )
}

sub dist{
    return int( sqrt( $_[0]*$_[0] + $_[1]*$_[1] ) )
}

sub newx{
    my($a,$b,$x,$y)=@_;
    return int( cos( atan2($y,$x) + atan2($b,$a) ) * sqrt( $x*$x + $y*$y ) );
}

sub newy{
    my($a,$b,$x,$y)=@_;
    return int( sin( atan2($y,$x) + atan2($b,$a) ) * sqrt( $x*$x + $y*$y ) );
}



sub draw_arrow {
    my($x1,$y1,$x2,$y2,$w,$solid,$color)=($_[0],$_[1],$_[2],$_[3],$_[4],$_[5],$_[6]);
    my($arrow)=new GD::Polygon;

    $arrow->addPt(
        $x1 + &newx($x2-$x1, $y2-$y1, 0, $w),
        $y1 + &newy($x2-$x1, $y2-$y1, 0, $w)
        );

    $arrow->addPt(
        $x2 + &newx($x2-$x1, $y2-$y1, -2*$w, $w),
        $y2 + &newy($x2-$x1, $y2-$y1, -2*$w, $w)
        );

    $arrow->addPt(
        $x2 + &newx($x2-$x1, $y2-$y1, -2*$w, 2*$w),
        $y2 + &newy($x2-$x1, $y2-$y1, -2*$w, 2*$w)
        );

    $arrow->addPt( $x2, $y2);

    $arrow->addPt(
        $x2 + &newx($x2-$x1, $y2-$y1, -2*$w, -2*$w),
        $y2 + &newy($x2-$x1, $y2-$y1, -2*$w, -2*$w)
        );

    $arrow->addPt(
        $x2 + &newx($x2-$x1, $y2-$y1, -2*$w, -$w),
        $y2 + &newy($x2-$x1, $y2-$y1, -2*$w, -$w)
        );

    $arrow->addPt(
        $x1 + &newx($x2-$x1, $y2-$y1, 0, -$w),
        $y1 + &newy($x2-$x1, $y2-$y1, 0, -$w)
        );

    if($solid){
        $map->filledPolygon($arrow,$color);
    }else{
        $map->polygon($arrow,$color);
    }
}


sub version {
        print <<EOM;
Network Wearthermap v$VERSION - http://netmon.grnet.gr/weathermap/
EOM
}

sub usage {
        print <<EOM;
Network Wearthermap v$VERSION - http://netmon.grnet.gr/weathermap/
Usage: $0 [OPTION]...

 -c, --config=FILE  configuration file (default $CONFIG)
 -o, --output=FILE  output image file default (default $OUTPUT)
 -v, --version      print version
 -h, --help         print this text
 -d, --debug        enable debug output

EOM
}
