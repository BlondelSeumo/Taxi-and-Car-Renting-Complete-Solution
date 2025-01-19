// ignore_for_file: prefer_final_fields, unused_field, prefer_typing_uninitialized_variables, use_key_in_widget_constructors, prefer_interpolation_to_compose_strings, unnecessary_string_interpolations, await_only_futures, avoid_print, prefer_const_constructors, avoid_unnecessary_containers, file_names
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:webview_flutter/webview_flutter.dart';
import 'dart:convert';
import 'package:http/http.dart' as http;
import '../model/paystack_model.dart';
import '../utils/config.dart';
import '../utils/Custom_widget.dart';


class Paystackweb extends StatefulWidget {
  final String? email;
  final String? totalAmount;
  final String skID;
  final String url;

  const Paystackweb({this.email, this.totalAmount, required this.skID, required this.url});

  @override
  State<Paystackweb> createState() => _PaystackwebState();
}

class _PaystackwebState extends State<Paystackweb> {
  GlobalKey<ScaffoldState> _scaffoldKey = GlobalKey<ScaffoldState>();
  late WebViewController _controller;
  var progress;
  String? accessToken;
  String? payerID;
  bool isLoading = true;
  PayStackController payStackController = Get.put(PayStackController());

  @override
  Widget build(BuildContext context) {
    if (_scaffoldKey.currentState == null) {
      return Scaffold(
        body: SafeArea(
          child: Stack(
            children: [
              WebView(
                initialUrl: widget.url,
                javascriptMode: JavascriptMode.unrestricted,
                navigationDelegate: (NavigationRequest request) async {
                  final uri = Uri.parse(request.url);
                  payStackController.paystackCheck(skKey: widget.skID).then((value) {
                    print("PAYMENT STATUS Response: >>>>>>>>>>>>>>>> ${value}");
                    print("PAYMENT STATUS Response: >>>>>>>>>>>>>>>> ${value["status"]}");
                    // print("PAYMENT SUCCESSS STATUS > > > > > > > > > > > > > ${value}");
                    if(value["status"] == true){
                      verifyPaystack = 1;
                      Get.back();
                    } else {
                      verifyPaystack = 0;
                    }
                  },
                  );
                  return NavigationDecision.navigate;
                },
                gestureNavigationEnabled: true,
                onWebViewCreated: (controller) {
                  _controller = controller;
                },
                onPageFinished: (finish) {
                  setState(()  {
                    isLoading = false;
                  });
                },
                onProgress: (val) {
                  progress = val;
                  setState(() {});
                },
              ),
              isLoading
                  ? Center(
                child: Column(
                  mainAxisAlignment: MainAxisAlignment.center,
                  crossAxisAlignment: CrossAxisAlignment.center,
                  children: [
                    SizedBox(
                      child: CircularProgressIndicator(),
                    ),
                    SizedBox(height: Get.height * 0.02),
                    SizedBox(
                      width: Get.width * 0.80,
                      child: Text(
                        'Please don`t press back until the transaction is complete'
                            .tr,
                        maxLines: 2,
                        textAlign: TextAlign.center,
                        overflow: TextOverflow.ellipsis,
                        style: TextStyle(
                            color: Colors.black,
                            fontSize: 15,
                            fontWeight: FontWeight.w500,
                            letterSpacing: 0.5),
                      ),
                    ),
                  ],
                ),
              )
                  : Stack(),
            ],
          ),
        ),
      );
    } else {
      return Scaffold(
        key: _scaffoldKey,
        appBar: AppBar(
          leading: IconButton(
            icon: const Icon(Icons.arrow_back),
            onPressed: () => Get.back(),
          ),
          backgroundColor: Colors.black12,
          elevation: 0.0,
        ),
        body: Center(
          child: Container(
            child: CircularProgressIndicator(),
          ),
        ),
      );
    }
  }
}

int verifyPaystack = -1;

class PayStackController extends GetxController implements GetxService {

  PayStackModel? payStackModel;

  Future paystackApi({required context,required String email,required String amount}) async{
    Map body = {
      "email": email,
      "amount": amount
    };

    Map<String, String> userHeader = {"Content-type": "application/json", "Accept": "application/json"};
    var response = await http.post(Uri.parse(Config.pGateway + Config.payStack),body: jsonEncode(body),headers: userHeader);

    print("++++++++++++++++ ${body}");
    print("---------------- ${response.body}");

    var data = jsonDecode(response.body);

    if(response.statusCode == 200){
      if(data["status"] == true){
        payStackModel = payStackModelFromJson(response.body);
        if(payStackModel!.status == true){
          randomKey = payStackModel!.data.reference;
          update();
          return payStackModel!.data.authorizationUrl;
        }
        else{
          ScaffoldMessenger.of(context).showSnackBar(
            SnackBar(content: Text(payStackModel!.status.toString()),behavior: SnackBarBehavior.floating, shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10))),
          );
        }
      }
      else{
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(content: Text("${data["message"]}"),behavior: SnackBarBehavior.floating, shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10))),
        );
      }
    }
    else{
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(content: const Text("Please update the content from the backend panel. It appears that the correct data was not uploaded, or there may be issues with the data that was added."),behavior: SnackBarBehavior.floating, shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10))),
      );
    }
  }


  String randomKey = "";

  Future paystackCheck({required String skKey}) async {

    var headers = {
      'accept': 'application/json',
      'authorization': 'Bearer $skKey',
      'cache-control': 'no-cache',
      'Cookie': '__cf_bm=nKw4bfwPAY5QJ8dPIH0qS4Dp.Y1TlO.VD1Irv9WAQng-1719051250-1.0.1.1-jBLW_9zjUIrwPtUoTO_RneCcm.aXgbDffT6geT2F9ck0Oru98__c4SekTkQT_zcHtR45Lzil61auKdc1ds_2eA; sails.sid=s%3Aey_lysqt0ZrbDS77szUh-7g1eG_AxjFo.aq4qmVSMZzoCG9un%2FiKh4FVMyxXvAcGIcEpWLPl%2BPdA'
    };

    print(" < > < >? <> < > < > < > < > < > < > < > < >? < $skKey");
    print(" < > <++_+_+_+_+_+_ +_ +_ +_ +_ +_ +_  $randomKey");
    var request = await http.get(Uri.parse('https://api.paystack.co/transaction/verify/$randomKey'),headers: headers);

    // http.StreamedResponse response = await request.send();

    if (request.statusCode == 200) {
      print("RWSPONSE CODE : ? ${request.body}");
      return jsonDecode(request.body);
    }
    else {
      // print(response.reasonPhrase);
    }

  }
}


