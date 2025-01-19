// ignore_for_file: non_constant_identifier_names, empty_catches, prefer_typing_uninitialized_variables, unused_import
import 'dart:convert';
import 'dart:io';
import 'dart:ui' as ui;
import 'package:carlink/controller/home_controller.dart';
import 'package:carlink/model/explore_modal.dart';
import 'package:carlink/utils/common_ematy.dart';
import 'package:carlink/utils/common.dart';
import 'package:carousel_slider/carousel_slider.dart';
import 'package:flutter/services.dart';
import 'package:geocoding/geocoding.dart';
import 'package:geolocator/geolocator.dart';
import 'package:http/http.dart'as http;
import 'package:carlink/utils/config.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:google_maps_flutter/google_maps_flutter.dart';
import 'package:permission_handler/permission_handler.dart';
import 'package:provider/provider.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'package:shimmer/shimmer.dart';
import '../../utils/App_content.dart';
import '../../utils/Colors.dart';
import '../../utils/Custom_widget.dart';
import '../../utils/Dark_lightmode.dart';
import '../../utils/fontfameli_model.dart';
import '../detailcar/cardetails_screen.dart';
import '../login_flow/onbording_screen.dart';

class ExploreScreen extends StatefulWidget {
  const ExploreScreen({super.key});

  @override
  State<ExploreScreen> createState() => _ExploreScreenState();
}

class _ExploreScreenState extends State<ExploreScreen> {
  ExploreController exploreController = Get.find();
  late ColorNotifire notifire;

  @override
  void initState() {
    getCurrentLatAndLong();
    getvalidate();
    super.initState();
    exploreController.shimmer();
  }


  late GoogleMapController mapController;
  Set<Marker> markers = {};

  ExploreModal?exploreModal;
  bool loading = true;

  var latData;
  var longData;
  bool isLoading = false;

  Future explore(uid,lat,lng,cityId) async {
    Map body = {
      "uid": uid,
      "lats": lat,
      "longs": lng,
      "cityid": cityId ?? 0,
    };
    try{
      var response = await http.post(Uri.parse(Config.baseUrl+Config.explore),body: jsonEncode(body), headers: {
        'Content-Type': 'application/json',
      });
      print("+++++++++++++++++++ $body");
      if(response.statusCode == 200){
        print("+++++++++++++++++++ ${response.body}");
        setState(()  {
          exploreModal = exploreModalFromJson(response.body);
          loading = false;

        });
        final Uint8List markIcon = await getImages(Appcontent.mapPin, 90);
        markers.add(Marker(

          markerId: const MarkerId('1'),
          position: LatLng(
            double.parse(exploreModal?.featureCar[0].pickLat ?? "" ),
            double.parse(exploreModal?.featureCar[0].pickLng ?? ""),
          ),
          icon: BitmapDescriptor.fromBytes(markIcon), //position of marker

          onTap: () {
            // print(i.toString());
          },
        ));
        setState(() {});
        var data = jsonDecode(response.body.toString());
        return data;
      } else {}
    } catch(e){
      Text(e.toString());
    }
  }

  var currencies;
  Future getvalidate() async {
    SharedPreferences sharedPreferences = await SharedPreferences.getInstance();
    var id = jsonDecode(sharedPreferences.getString('UserLogin')!);
    // var lat = jsonDecode(sharedPreferences.getString('lats')!);
    // var lng = jsonDecode(sharedPreferences.getString('longs')!);
    var lId = jsonDecode(sharedPreferences.getString('lId') ?? "0");
    currencies = jsonDecode(sharedPreferences.getString('bannerData')!);
    explore(id['id'], lat, long, lId);
  }

  Future getvalidate1({required String latitude,required String longitude}) async {
    SharedPreferences sharedPreferences = await SharedPreferences.getInstance();
    var id = jsonDecode(sharedPreferences.getString('UserLogin')!);
    // var lat1 = jsonDecode(sharedPreferences.getString('lats')!);
    // var lng = jsonDecode(sharedPreferences.getString('longs')!);
    var lId = jsonDecode(sharedPreferences.getString('lId') ?? "0");
    currencies = jsonDecode(sharedPreferences.getString('bannerData')!);
    isLoading = true;
    explore(id['id'], latitude, longitude, lId);
    setState(() {

    });
  }



  int Index = 0;
  CarouselController carouselController = CarouselController();

  // getCurrentLatAndLong() async {
  //   LocationPermission permission = await Geolocator.checkPermission();
  //
  //   if (permission == LocationPermission.denied) {
  //     permission = await Geolocator.requestPermission();
  //
  //     if (permission == LocationPermission.denied) {
  //       permission = await Geolocator.requestPermission();
  //       return; // Exit the function if permission is still denied
  //     }
  //   }
  //
  //   try {
  //     // Get the current location
  //     Position currentLocation = await Geolocator.getCurrentPosition(
  //       desiredAccuracy: LocationAccuracy.high,
  //     );
  //
  //     // Reverse geocoding to get address from coordinates
  //     List<Placemark> placemarks = await placemarkFromCoordinates(
  //       currentLocation.latitude,
  //       currentLocation.longitude,
  //     );
  //
  //     // Extract address details from the placemark
  //     String address = '${placemarks.first.name ?? ''}, '
  //         '${placemarks.first.thoroughfare ?? ''}, '
  //         '${placemarks.first.subLocality ?? ''}, '
  //         '${placemarks.first.locality ?? ''}, '
  //         '${placemarks.first.subAdministrativeArea ?? ''}, '
  //         '${placemarks.first.postalCode ?? ''}, '
  //         '${placemarks.first.administrativeArea ?? ''}';
  //
  //     setState(() {
  //       lat = currentLocation.latitude;
  //       long = currentLocation.longitude;
  //       // Update your UI with the obtained location and address details
  //     });
  //   } catch (e) {
  //     // Handle errors that might occur during location retrieval
  //     print('Error getting location: $e');
  //   }
  // }

  Future<Position> locateUser() async {
    return Geolocator.getCurrentPosition(desiredAccuracy: LocationAccuracy.high);
  }

  getCurrentLatAndLong() async {
    LocationPermission permission;
    permission = await Geolocator.checkPermission();
    permission = await Geolocator.requestPermission();

    var currentLocation = await locateUser();

    print("************************** ${currentLocation.latitude}");
    print("///////////////////////// ${currentLocation.longitude}");
    if (permission == LocationPermission.denied) {
      // openAppSettings();
    }else if(permission == LocationPermission.always || permission == LocationPermission.whileInUse){
      setState(() {
        getvalidate1(latitude: currentLocation.latitude.toString(), longitude: currentLocation.longitude.toString());
      });
    }
    await placemarkFromCoordinates(
        currentLocation.latitude, currentLocation.longitude)
        .then((List<Placemark> placeMarks) {
      address = '${placeMarks.first.name!.isNotEmpty ? '${placeMarks.first.name!}, ' : ''}${placeMarks.first.thoroughfare!.isNotEmpty ? '${placeMarks.first.thoroughfare!}, ' : ''}${placeMarks.first.subLocality!.isNotEmpty ? '${placeMarks.first.subLocality!}, ' : ''}${placeMarks.first.locality!.isNotEmpty ? '${placeMarks.first.locality!}, ' : ''}${placeMarks.first.subAdministrativeArea!.isNotEmpty ? '${placeMarks.first.subAdministrativeArea!}, ' : ''}${placeMarks.first.postalCode!.isNotEmpty ? '${placeMarks.first.postalCode!}, ' : ''}${placeMarks.first.administrativeArea!.isNotEmpty ? placeMarks.first.administrativeArea : ''}';
    });

    setState(() { });
  }


  @override
  Widget build(BuildContext context) {
    notifire = Provider.of<ColorNotifire>(context, listen: true);
    return Scaffold(
      backgroundColor: notifire.getbgcolor,
      appBar: AppBar(
        backgroundColor: notifire.getbgcolor,
        elevation: 0,
        centerTitle: true,
        title: Text('Explore'.tr, style: TextStyle(fontSize: 18, color: notifire.getwhiteblackcolor, fontFamily: FontFamily.europaBold)),
      ),
      // body:
      // loading
      //     ? Column(
      //   mainAxisAlignment: MainAxisAlignment.center,
      //   children: [
      //     Image.asset(Appcontent.ematyCar, height: 96),
      //     const SizedBox(height: 10),
      //     RichText(
      //         textAlign: TextAlign.center,
      //         text: TextSpan(
      //             children: [
      //               TextSpan(text: 'No'.tr, style:  TextStyle(fontSize: 24, fontFamily: FontFamily.europaBold, color: notifire.getwhiteblackcolor)),
      //               TextSpan(text: ' Nearby Car ', style:  TextStyle(fontSize: 24, fontFamily: FontFamily.europaBold, color: notifire.getwhiteblackcolor)),
      //               TextSpan(text: 'Found!'.tr, style:  TextStyle(fontSize: 24, fontFamily: FontFamily.europaBold, color: notifire.getwhiteblackcolor)),
      //             ]
      //         )),        const SizedBox(height: 10),
      //     RichText(
      //         textAlign: TextAlign.center,
      //         text: TextSpan(
      //             children: [
      //               TextSpan(text: 'It can be used to express that something is not someone'.tr, style:  TextStyle(fontSize: 16, fontFamily: FontFamily.europaWoff,color: greyScale),),
      //               TextSpan(text: ' Map', style:  TextStyle(fontSize: 16, fontFamily: FontFamily.europaWoff,color: greyScale)),
      //             ]
      //         )),
      //    const SizedBox(height: 20),
      //     GestButton(
      //       height: 50,
      //       buttoncolor: onbordingBlue,
      //       buttontext: "Add Location",
      //       margin: const EdgeInsets.symmetric(vertical: 3, horizontal: 20),
      //       style: TextStyle(
      //         fontFamily: FontFamily.europaBold,
      //         color: WhiteColor,
      //         fontSize: 15,
      //       ),
      //       onclick: () async {
      //
      //         PermissionStatus Status =
      //             await Permission.location.request();
      //         if (Status == PermissionStatus.granted) {
      //           getCurrentLatAndLong();
      //         } else {
      //           openAppSettings();
      //         }
      //       },
      //     ),
      //   ],
      // )
      //     : exploreModal!.featureCar.isEmpty
      //     ? ematyCar(title: 'Nearby Car'.tr,colors: notifire.getwhiteblackcolor)
      // :
      //     : GetBuilder<ExploreController>(
      //     builder: (context) {
      //       return Stack(
      //         clipBehavior: Clip.none,
      //         children: [
      //           GoogleMap(
      //             markers: markers,
      //             initialCameraPosition: CameraPosition(target: LatLng(double.parse(exploreModal!.featureCar[Index].pickLat), double.parse(exploreModal!.featureCar[Index].pickLng)), zoom: 13),
      //             mapType: MapType.normal,
      //             padding: EdgeInsets.only(bottom: Get.width*0.48),
      //             myLocationEnabled: false,
      //             zoomGesturesEnabled: true,
      //             tiltGesturesEnabled: true,
      //             zoomControlsEnabled: false,
      //             onMapCreated: (controller) {
      //               setState(() {
      //                 mapController = controller;
      //               });
      //             },
      //           ),
      //           Positioned(
      //               left: 10,
      //               right: 10,
      //               bottom: 10,
      //               child: SizedBox(
      //                 height: 165,
      //                 child:exploreController.load ? PageView.builder(
      //                   itemCount: exploreModal?.featureCar.length,
      //                   scrollDirection: Axis.horizontal,
      //                   onPageChanged: (value) {
      //                     mapController.animateCamera(
      //                       CameraUpdate.newCameraPosition(
      //                         CameraPosition(
      //                             target: LatLng(
      //                               double.parse(exploreModal?.featureCar[value].pickLat ?? "0"),
      //                               double.parse(exploreModal?.featureCar[value].pickLng ?? "0"),
      //                             ),
      //                             zoom: 13
      //                         ),
      //                       ),
      //                     );
      //                     setState(() {});
      //                     getmarkers(value);
      //                     markers.clear();
      //                   },
      //                   itemBuilder: (context, index) {
      //                     Index=index;
      //                     return InkWell(
      //                       onTap: () {
      //                         Get.to(CarDetailsScreen(id: exploreModal!.featureCar[index].id, currency: currencies['currency']));
      //                       },
      //                       child: Container(
      //                         height: 160,
      //                         width: Get.size.width,
      //                         padding: const EdgeInsets.symmetric(horizontal: 8),
      //                         margin: const EdgeInsets.only(right: 5),
      //                         decoration: BoxDecoration(
      //                           color: notifire.getblackwhitecolor,
      //                           borderRadius: BorderRadius.circular(15),
      //                         ),
      //                         child: Column(
      //                           children: [
      //                             const SizedBox(height: 10,),
      //                             Row(
      //                               children: [
      //                                 Container(
      //                                   height: 90,
      //                                   width: 140,
      //                                   decoration: BoxDecoration(
      //                                     borderRadius: BorderRadius.circular(10),
      //                                     image: DecorationImage(image: NetworkImage(Config.imgUrl+exploreModal!.featureCar[index].carImg.split("\$;").elementAt(0)),fit: BoxFit.cover),
      //                                   ),
      //                                 ),
      //                                 const SizedBox(width: 10),
      //                                 Expanded(
      //                                   child: Column(
      //                                     crossAxisAlignment: CrossAxisAlignment.start,
      //                                     children: [
      //                                       Text(exploreModal!.featureCar[index].carTitle, style: TextStyle(fontFamily: FontFamily.europaBold, fontSize: 15, color: notifire.getwhiteblackcolor,),),
      //                                       const SizedBox(height: 5,),
      //                                       Row(
      //                                         children: [
      //                                           Image.asset(Appcontent.star1, height: 16),
      //                                           const SizedBox(width: 5),
      //                                           Text(exploreModal!.featureCar[index].carRating, style: TextStyle(fontFamily: FontFamily.europaWoff, color: greyScale1, fontSize: 13,),),
      //                                         ],
      //                                       ),
      //                                       const SizedBox(height: 5,),
      //                                       Text(exploreModal!.featureCar[index].carNumber, style: TextStyle(fontFamily: FontFamily.europaBold, fontSize: 15, color: notifire.getwhiteblackcolor,),),
      //                                       // Text(exploreModal!.featureCar[index].pickAddress, style: TextStyle(fontFamily: FontFamily.europaBold, fontSize: 15, color: notifire.getwhiteblackcolor,),),
      //                                     ],
      //                                   ),
      //                                 ),
      //                               ],
      //                             ),
      //                             const SizedBox(height: 4,),
      //                             Divider(color: greyScale,),
      //                             const SizedBox(height: 4,),
      //                             Align(
      //                               alignment: Alignment.centerLeft,
      //                               child: SingleChildScrollView(
      //                                 scrollDirection: Axis.horizontal,
      //                                 child: Row(
      //                                   mainAxisAlignment: MainAxisAlignment.spaceEvenly,
      //                                   children: [
      //                                     carTool(image: Appcontent.engine, number: exploreModal!.featureCar[index].engineHp,text: 'hp'.tr),
      //                                     carTool(image: Appcontent.gearbox, title: exploreModal!.featureCar[index].carGear == '0'?'Automatic'.tr:'Manual'.tr),
      //                                     carTool(image: Appcontent.petrol,title: '${exploreModal!.featureCar[index].fuelType == '0' ?"Petrol".tr : exploreModal!.featureCar[index].fuelType == '1' ?"Diesel".tr :exploreModal!.featureCar[index].fuelType == '2' ? 'Electric'.tr : exploreModal!.featureCar[index].fuelType == '3' ? 'CNG'.tr:'Petrol & CNG'.tr} '),
      //                                     carTool(image: Appcontent.seat, number: exploreModal!.featureCar[index].totalSeat,text: 'Seats'.tr),
      //                                   ],
      //                                 ),
      //                               ),
      //                             ),
      //                           ],
      //                         ),
      //                       ),
      //                     );
      //                   },
      //                 ):exploreShimmer(),
      //               )),
      //         ],
      //       );
      //     }
      // ),
      body: loading
          ? loader()
          : exploreModal!.featureCar.isEmpty
          ? ematyCar(title: 'Nearby Car'.tr,colors: notifire.getwhiteblackcolor)
          : GetBuilder<ExploreController>(
          builder: (context) {
            return Stack(
              clipBehavior: Clip.none,
              children: [
                GoogleMap(
                  markers: markers,
                  initialCameraPosition: CameraPosition(target: LatLng(double.parse(exploreModal!.featureCar[Index].pickLat), double.parse(exploreModal!.featureCar[Index].pickLng)), zoom: 13),
                  mapType: MapType.normal,
                  padding: EdgeInsets.only(bottom: Get.width*0.48),
                  myLocationEnabled: false,
                  zoomGesturesEnabled: true,
                  tiltGesturesEnabled: true,
                  zoomControlsEnabled: false,
                  onMapCreated: (controller) {
                    setState(() {
                      mapController = controller;
                    });
                  },
                ),
                Positioned(
                    left: 10,
                    right: 10,
                    bottom: 10,
                    child: SizedBox(
                      height: 165,
                      child:exploreController.load ? PageView.builder(
                        itemCount: exploreModal?.featureCar.length,
                        scrollDirection: Axis.horizontal,
                        onPageChanged: (value) {
                          mapController.animateCamera(
                            CameraUpdate.newCameraPosition(
                              CameraPosition(
                                  target: LatLng(
                                    double.parse(exploreModal?.featureCar[value].pickLat ?? "0"),
                                    double.parse(exploreModal?.featureCar[value].pickLng ?? "0"),
                                  ),
                                  zoom: 13
                              ),
                            ),
                          );
                          setState(() {});
                          getmarkers(value);
                          markers.clear();
                        },
                        itemBuilder: (context, index) {
                          Index=index;
                          return InkWell(
                            onTap: () {
                              Get.to(CarDetailsScreen(id: exploreModal!.featureCar[index].id, currency: currencies['currency']));
                            },
                            child: Container(
                              height: 160,
                              width: Get.size.width,
                              padding: const EdgeInsets.symmetric(horizontal: 8),
                              margin: const EdgeInsets.only(right: 5),
                              decoration: BoxDecoration(
                                color: notifire.getblackwhitecolor,
                                borderRadius: BorderRadius.circular(15),
                              ),
                              child: Column(
                                children: [
                                  const SizedBox(height: 10,),
                                  Row(
                                    children: [
                                      Container(
                                        height: 90,
                                        width: 140,
                                        decoration: BoxDecoration(
                                          borderRadius: BorderRadius.circular(10),
                                          image: DecorationImage(image: NetworkImage(Config.imgUrl+exploreModal!.featureCar[index].carImg.split("\$;").elementAt(0)),fit: BoxFit.cover),
                                        ),
                                      ),
                                      const SizedBox(width: 10),
                                      Expanded(
                                        child: Column(
                                          crossAxisAlignment: CrossAxisAlignment.start,
                                          children: [
                                            Text(exploreModal!.featureCar[index].carTitle, style: TextStyle(fontFamily: FontFamily.europaBold, fontSize: 15, color: notifire.getwhiteblackcolor,),),
                                            const SizedBox(height: 5,),
                                            Row(
                                              children: [
                                                Image.asset(Appcontent.star1, height: 16),
                                                const SizedBox(width: 5),
                                                Text(exploreModal!.featureCar[index].carRating, style: TextStyle(fontFamily: FontFamily.europaWoff, color: greyScale1, fontSize: 13,),),
                                              ],
                                            ),
                                            const SizedBox(height: 5,),
                                            Text(exploreModal!.featureCar[index].carNumber, style: TextStyle(fontFamily: FontFamily.europaBold, fontSize: 15, color: notifire.getwhiteblackcolor,),),
                                            // Text(exploreModal!.featureCar[index].pickAddress, style: TextStyle(fontFamily: FontFamily.europaBold, fontSize: 15, color: notifire.getwhiteblackcolor,),),
                                          ],
                                        ),
                                      ),
                                    ],
                                  ),
                                  const SizedBox(height: 4,),
                                  Divider(color: greyScale,),
                                  const SizedBox(height: 4,),
                                  Align(
                                    alignment: Alignment.centerLeft,
                                    child: SingleChildScrollView(
                                      scrollDirection: Axis.horizontal,
                                      child: Row(
                                        mainAxisAlignment: MainAxisAlignment.spaceEvenly,
                                        children: [
                                          carTool(image: Appcontent.engine, number: exploreModal!.featureCar[index].engineHp,text: 'hp'.tr),
                                          carTool(image: Appcontent.gearbox, title: exploreModal!.featureCar[index].carGear == '0'?'Automatic'.tr:'Manual'.tr),
                                          carTool(image: Appcontent.petrol,title: '${exploreModal!.featureCar[index].fuelType == '0' ?"Petrol".tr : exploreModal!.featureCar[index].fuelType == '1' ?"Diesel".tr :exploreModal!.featureCar[index].fuelType == '2' ? 'Electric'.tr : exploreModal!.featureCar[index].fuelType == '3' ? 'CNG'.tr:'Petrol & CNG'.tr} '),
                                          carTool(image: Appcontent.seat, number: exploreModal!.featureCar[index].totalSeat,text: 'Seats'.tr),
                                        ],
                                      ),
                                    ),
                                  ),
                                ],
                              ),
                            ),
                          );
                        },
                      ):exploreShimmer(),
                    )),
              ],
            );
          }
      ),
    );
  }
  exploreShimmer() {
    return Container(
      height: 160,
      width: Get.width,
      margin: const EdgeInsets.all(5),
      alignment: Alignment.center,
      child: SizedBox(
        height: 165,
        child: PageView.builder(
          itemCount: exploreModal?.featureCar.length,
          scrollDirection: Axis.horizontal,
          itemBuilder: (context, index) {
            return Container(
              height: 160,
              width: Get.size.width,
              padding: const EdgeInsets.symmetric(horizontal: 8),
              margin: const EdgeInsets.only(right: 5),
              decoration: BoxDecoration(
                color: notifire.getblackwhitecolor,
                borderRadius: BorderRadius.circular(15),
              ),
              child: Shimmer.fromColors(
                baseColor: notifire.isDark ? Colors.black45 : Colors.grey.shade100,
                highlightColor: notifire.isDark ? const Color(0xFF475569) : const Color(0xFFeaeff4),
                enabled: true,
                child: Column(
                  children: [
                    const SizedBox(
                      height: 15,
                    ),
                    Row(
                      children: [
                        Container(
                          height: 90,
                          width: 140,
                          decoration: BoxDecoration(
                            color: notifire.getblackwhitecolor,
                            borderRadius: BorderRadius.circular(10),
                          ),
                        ),
                        const SizedBox(width: 10),
                        Column(
                          crossAxisAlignment: CrossAxisAlignment.start,
                          children: [
                            Container(
                              height: 15,
                              width: 90,
                              decoration: BoxDecoration(
                                color: notifire.getblackwhitecolor,
                                borderRadius: BorderRadius.circular(5),
                              ),
                            ),
                            Padding(
                              padding: const EdgeInsets.only(top: 7),
                              child: Container(
                                height: 15,
                                width: 45,
                                decoration: BoxDecoration(
                                  color: notifire.getblackwhitecolor,
                                  borderRadius: BorderRadius.circular(5),
                                ),
                              ),
                            ),
                            Padding(
                              padding: const EdgeInsets.only(top: 7),
                              child: Container(
                                height: 15,
                                width: 60,
                                decoration: BoxDecoration(
                                  color: notifire.getblackwhitecolor,
                                  borderRadius: BorderRadius.circular(5),
                                ),
                              ),
                            ),
                          ],
                        ),
                      ],
                    ),
                    const SizedBox(
                      height: 8,
                    ),
                    Row(
                      mainAxisAlignment: MainAxisAlignment.spaceAround,
                      children: [
                        Container(
                          height: 30,
                          width: 30,
                          decoration: BoxDecoration(
                            borderRadius: BorderRadius.circular(5),
                            color: notifire.getblackwhitecolor,
                          ),
                        ),
                        const SizedBox(
                          width: 4,
                        ),
                        Container(
                          height: 30,
                          width: 50,
                          decoration: BoxDecoration(
                            borderRadius: BorderRadius.circular(5),
                            color: notifire.getblackwhitecolor,
                          ),
                        ),
                        const SizedBox(
                          width: 10,
                        ),
                        Container(
                          height: 30,
                          width: 30,
                          decoration: BoxDecoration(
                            borderRadius: BorderRadius.circular(5),
                            color: notifire.getblackwhitecolor,
                          ),
                        ),
                        const SizedBox(
                          width: 4,
                        ),
                        Container(
                          height: 30,
                          width: 50,
                          decoration: BoxDecoration(
                            borderRadius: BorderRadius.circular(5),
                            color: notifire.getblackwhitecolor,
                          ),
                        ),
                        const SizedBox(
                          width: 10,
                        ),
                        Container(
                          height: 30,
                          width: 30,
                          decoration: BoxDecoration(
                            borderRadius: BorderRadius.circular(5),
                            color: notifire.getblackwhitecolor,
                          ),
                        ),
                        const SizedBox(
                          width: 4,
                        ),
                        Container(
                          height: 30,
                          width: 50,
                          decoration: BoxDecoration(
                            borderRadius: BorderRadius.circular(5),
                            color: notifire.getblackwhitecolor,
                          ),
                        ),
                      ],
                    )
                  ],
                ),
              ),
            );
          },
        ),
      ),
    );
  }

  Widget carTool({required String image,  String? title, String? number, String? text}){
    return Row(
      children: [
        const SizedBox(width: 4),
        Image.asset(image, height: 20, width: 20, color: notifire.getwhiteblackcolor),
        const SizedBox(width: 4),
        Text(title ?? '', style:  TextStyle(fontFamily: FontFamily.europaWoff, color: notifire.getwhiteblackcolor, fontSize: 13)),
        RichText(text: TextSpan(
          children: [
            TextSpan(text: number,style:  TextStyle(fontFamily: FontFamily.europaWoff, color: notifire.getwhiteblackcolor, fontSize: 13)),
            const WidgetSpan(child: SizedBox(width: 5)),
            TextSpan(text: text,style:  TextStyle(fontFamily: FontFamily.europaWoff, color: notifire.getwhiteblackcolor, fontSize: 13)),
            const WidgetSpan(child: SizedBox(width: 10)),
          ],
        )),
      ],
    );
  }

  Future<Uint8List> getImages(String path, int width) async {
    ByteData data = await rootBundle.load(path);
    ui.Codec codec = await ui.instantiateImageCodec(data.buffer.asUint8List(), targetHeight: width);
    ui.FrameInfo fi = await codec.getNextFrame();
    return (await fi.image.toByteData(format: ui.ImageByteFormat.png))!
        .buffer
        .asUint8List();
  }

  getmarkers(i) async {
    final Uint8List markIcon = await getImages(Appcontent.mapPin, 70);

    setState(() {
      markers.add(Marker(

        markerId: MarkerId(i.toString()),
        position: LatLng(
          double.parse(exploreModal!.featureCar[i].pickLat),
          double.parse(exploreModal!.featureCar[i].pickLng),
        ),
        icon: BitmapDescriptor.fromBytes(markIcon), //position of marker

        onTap: () {
        },
      ));
    });

  }


}
