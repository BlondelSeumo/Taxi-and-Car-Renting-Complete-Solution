import 'dart:convert';

import 'package:fluttertoast/fluttertoast.dart';
import 'package:get/get.dart';
import 'package:http/http.dart' as http;
import '../model/twillio_otp_model.dart';
import '../utils/config.dart';



class TwilioOtpController extends GetxController implements GetxService {

  TwilioOtpModel? twilioOtpModel;

  Future twilioOtpApi({required String mobile}) async{
    Map body = {
      "mobile": mobile
    };
    Map<String, String> userHeader = {"Content-type": "application/json", "Accept": "application/json"};
    var response = await http.post(Uri.parse(Config.baseUrl + Config.twilioOtp),body: jsonEncode(body),headers: userHeader);

    print("+++++++ ${response.body}");
    print("----- $body");

    var data = jsonDecode(response.body);
    if(response.statusCode == 200){
      if(data["Result"] == "true"){
        twilioOtpModel = twilioOtpModelFromJson(response.body);
        if(twilioOtpModel!.result == "true"){
          update();
          return data;
        }
        else{
          Fluttertoast.showToast(msg: twilioOtpModel!.result.toString());
        }
      }
      else{
        Fluttertoast.showToast(msg: "${data["ResponseMsg"]}",);
      }
    }else{
      Fluttertoast.showToast(msg: "Please update the content from the backend panel. It appears that the correct data was not uploaded, or there may be issues with the data that was added.",);
    }
  }
}