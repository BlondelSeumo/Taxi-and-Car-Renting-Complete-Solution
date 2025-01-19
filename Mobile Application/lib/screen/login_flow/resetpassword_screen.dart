// ignore_for_file: prefer_const_constructors, use_key_in_widget_constructors, must_be_immutable, empty_catches
import 'dart:convert';
import 'package:carlink/screen/login_flow/otp1_screen.dart';
import 'package:carlink/utils/Colors.dart';
import 'package:carlink/utils/Custom_widget.dart';
import 'package:carlink/utils/Dark_lightmode.dart';
import 'package:carlink/utils/fontfameli_model.dart';
import 'package:firebase_auth/firebase_auth.dart';
import 'package:flutter/material.dart';
import 'package:fluttertoast/fluttertoast.dart';
import 'package:get/get.dart';
import 'package:intl_phone_field/intl_phone_field.dart';
import 'package:provider/provider.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'package:http/http.dart' as http;
import '../../controller/msg_otp_controller.dart';
import '../../controller/sms_type_controller.dart';
import '../../controller/twilio_otp_controller.dart';
import '../../utils/common.dart';
import '../../utils/config.dart';
import 'newpassword_screen.dart';
import 'otp_screen.dart';

class ResetPasswordScreen extends StatefulWidget {
  const ResetPasswordScreen({super.key});

  @override
  State<ResetPasswordScreen> createState() => _ResetPasswordScreenState();
}

class _ResetPasswordScreenState extends State<ResetPasswordScreen> {
  TextEditingController email = TextEditingController();
  final _formKey = GlobalKey<FormState>();

  late ColorNotifire notifire;
  getdarkmodepreviousstate() async {
    final prefs = await SharedPreferences.getInstance();
    bool? previusstate = prefs.getBool("setIsDark");
    if (previusstate == null) {
      notifire.setIsDark = false;
    } else {
      notifire.setIsDark = previusstate;
    }
  }

  TextEditingController mobileController = TextEditingController();
  SmsTypeController smsTypeController = Get.put(SmsTypeController());
  MsgOtpController msgOtpController = Get.put(MsgOtpController());
  TwilioOtpController twilioOtpController = Get.put(TwilioOtpController());
  String ccode = "";

  bool isLoading = false;

  Future mCheck(mobile, ccode) async {
    Map body = {
      'mobile' : mobile,
      'ccode' : ccode,
    };
    try{
      var response = await http.post(Uri.parse(Config.baseUrl+Config.mobileCheck), body: jsonEncode(body), headers: {
        'Content-Type': 'application/json',
      });
      if(response.statusCode == 200){
        var data = jsonDecode(response.body.toString());
        return data;
      } else {
      }
    } catch(e){}
  }
  @override
  Widget build(BuildContext context) {
    notifire = Provider.of<ColorNotifire>(context, listen: true);
    return Scaffold(
      backgroundColor: notifire.getbgcolor,
      bottomNavigationBar: SizedBox(
        height: 135,
        width: Get.size.width,
        child: Column(
          children: [
            GestButton(
              height: 50,
              Width: Get.size.width,
              buttoncolor: onbordingBlue,
              buttontext: "Reset Password".tr,
              margin: EdgeInsets.symmetric(vertical: 3, horizontal: 20),
              style: TextStyle(
                fontFamily: FontFamily.europaBold,
                color: WhiteColor,
                fontSize: 15,
              ),
              onclick: () {
                if(mobileController.text.isNotEmpty){
                  mCheck(mobileController.text, ccode).then((value) {
                    if(value["ResponseCode"] == "401"){
                      // registerID();
                      smsTypeController.smsTypeApi().then((smsType) {
                        if(smsType["Result"] == "true"){
                          print("cscvdxvdcvfcbgbgn");
                          if(smsType["otp_auth"] == "No"){
                            // signUpController.setUserApiData(cuntryCode);
                            Get.to(NewPasswordScreen(conutry: ccode, mobile: mobileController.text));
                          }else {
                            if (smsType["SMS_TYPE"] == "Firebase") {
                              print("cscvdxvdcvfcbgbgn");
                              registerID(smsType: smsType["SMS_TYPE"]);
                              // Get.to(() =>
                              //     OtpScreen(
                              //       ccode: ccode,
                              //       number: mobileController.text,
                              //       Email: emailController.text,
                              //       FullName: fullName.text,
                              //       Password: passwordController.text,
                              //       Signup: "signUpScreen",
                              //       otpCode: "",
                              //       msgType: smsType["SMS_TYPE"],
                              //
                              //     ));
                            } else if (smsType["SMS_TYPE"] == "Msg91") {
                              //  msg_otp;
                              print("cscvdxvdcvfcbgbgn");
                              msgOtpController.msgOtpApi(mobile: "$ccode${mobileController.text}").then((msgOtp) {
                                print("************* $msgOtp");
                                if (msgOtp["Result"] == "true") {
                                  Get.to(() =>
                                      OtpScreen(
                                        ccode: ccode,
                                        number: mobileController.text,
                                        Email: "",
                                        FullName: "",
                                        Password: "",
                                        Signup: "resetScreen",
                                        otpCode: msgOtp["otp"].toString(),
                                        msgType: smsType["SMS_TYPE"],
                                      ));
                                  print("++++++++msgOtp+++++++++++ ${msgOtp["otp"]}");
                                } else {
                                  showToastMessage(
                                      "Invalid mobile number");
                                }
                              },);
                            } else if (smsType["SMS_TYPE"] == "Twilio") {
                              print("cscvdxvdcvfcbgbgn");
                              twilioOtpController.twilioOtpApi(
                                  mobile: "$ccode${mobileController.text}").then((twilioOtp) {
                                print("---------- $twilioOtp");
                                if (twilioOtp["Result"] == "true") {
                                  Get.to(() =>
                                      OtpScreen(
                                        ccode: ccode,
                                        number: mobileController.text,
                                        Email: "",
                                        FullName: "",
                                        Password: "",
                                        Signup: "resetScreen",
                                        otpCode: twilioOtp["otp"].toString(),
                                        msgType: smsType["SMS_TYPE"],
                                      ));
                                  print(
                                      "++++++++twilioOtp+++++++++++ ${twilioOtp["otp"]}");
                                } else {
                                  showToastMessage(
                                      "Invalid mobile number".tr);
                                }
                              },);
                            } else {
                              showToastMessage(
                                  "Invalid mobile number".tr);
                            }
                          }
                        }else{
                          showToastMessage("Invalid mobile number".tr);
                        }
                      }
                      );
                    } else {
                      Fluttertoast.showToast(msg: value['ResponseMsg']);
                    }
                  });
                }
              },
            ),
            SizedBox(height: 10),
            NormalButton(
              height: 50,
              width: Get.size.width,
              margin: EdgeInsets.symmetric(vertical: 3, horizontal: 20),
              buttonText: "Return to Sign In".tr,
              style: TextStyle(
                fontFamily: FontFamily.europaBold,
                color: onbordingBlue,
                fontSize: 15,
              ),
              border: Border.all(color: onbordingBlue),
              onTap: () {
                Get.back();
              },
            ),
            SizedBox(height: 10),
          ],
        ),
      ),
      body: SafeArea(
        child: Padding(
          padding: const EdgeInsets.symmetric(horizontal: 15),
          child: Form(
            key: _formKey,
            child: Stack(
              children: [
                Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    SizedBox(
                      height: 10,
                    ),
                    InkWell(
                      onTap: () {
                        Get.back();
                      },
                      child: Container(
                        height: 40,
                        width: 40,
                        alignment: Alignment.center,
                        padding: EdgeInsets.all(6),
                        child: Image.asset(
                          "assets/x.png",
                          color: notifire.getwhiteblackcolor,
                        ),
                      ),
                    ),
                    SizedBox(height: Get.size.height * 0.04),
                    Container(
                      height: 100,
                      width: Get.size.width,
                      alignment: Alignment.center,
                      child: Image.asset("assets/EmptyPassword.png"),
                    ),
                    SizedBox(height: 10),
                    Container(
                      width: Get.size.width,
                      alignment: Alignment.center,
                      child: Text(
                        "Can’t sign in?".tr,
                        style: TextStyle(
                          fontFamily: FontFamily.europaBold,
                          color: notifire.getwhiteblackcolor,
                          fontSize: 20,
                        ),
                      ),
                    ),
                    SizedBox(
                      height: 10,
                    ),
                    Container(
                      width: Get.size.width,
                      alignment: Alignment.center,
                      child: Text(
                        'Enter the mobile number associated with your account, and RideNow will send you a OTP to your register mobile number'
                            .tr,
                        textAlign: TextAlign.center,
                        style: TextStyle(
                          fontFamily: FontFamily.europaWoff,
                          color: greyScale,
                          fontSize: 15,
                        ),
                      ),
                    ),
                    SizedBox(height: Get.size.height * 0.035),
                    IntlPhoneField(
                      controller: mobileController,
                      decoration:  InputDecoration(
                        counterText: "",
                        filled: true,
                        fillColor: notifire.getblackwhitecolor,
                        enabledBorder: OutlineInputBorder(
                            borderSide: BorderSide.none,
                            borderRadius: BorderRadius.circular(15)
                        ),
                        hintText: 'Phone Number'.tr,
                        hintStyle: TextStyle(color: greyColor, fontSize: 14, fontFamily: FontFamily.europaWoff),
                        border:  OutlineInputBorder(
                          borderSide: BorderSide.none,
                          borderRadius: BorderRadius.circular(15),
                        ),
                        focusedBorder: OutlineInputBorder(
                          borderSide:  BorderSide(color: onbordingBlue),
                          borderRadius: BorderRadius.circular(15),
                        ),
                      ),
                      style: TextStyle(color: notifire.getwhiteblackcolor, fontFamily: FontFamily.europaBold),
                      flagsButtonPadding: EdgeInsets.only(left: 7),
                      showCountryFlag: false,
                      dropdownIcon: Icon(Icons.phone_outlined, color: greyScale),
                      initialCountryCode: 'IN',
                      onCountryChanged: (value) {
                        setState(() {
                          ccode = value.dialCode;
                        });
                      },
                      onChanged: (number) {
                        setState(() {
                          ccode = number.countryCode;
                        });
                      },
                    ),
                  ],
                ),
                isLoading ? loader() : SizedBox(),
              ],
            ),
          ),
        ),
      ),
    );
  }
  Future registerID({required String smsType}) async {
    FirebaseAuth auth = FirebaseAuth.instance;
    try{
      setState(() {
        isLoading = true;
      });
      await auth.verifyPhoneNumber(
        phoneNumber: ccode + mobileController.text,
        verificationCompleted: (phoneAuthCredential) async {
          await auth.signInWithCredential(phoneAuthCredential).then((value) {});
        },
        verificationFailed: (error) {
        },
        codeSent: (verificationId, forceResendingToken) {
          setState(() {
            isLoading = false;
          });
          Get.to(() =>
              OtpScreen(
                ccode: ccode,
                number: mobileController.text,
                Email: "",
                FullName: "",
                Password: "",
                Signup: "signUpScreen",
                otpCode: "",
                msgType: smsType,

              ));
          // Navigator.push(context, MaterialPageRoute(builder: (context) => Otp1Screen(mNumber: mobileController.text, country: ccode, vId: verificationId)));
        },
        codeAutoRetrievalTimeout: (verificationId) {},
      );
    } catch(e){}
  }
}