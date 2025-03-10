// ignore_for_file: prefer_const_constructors, empty_catches, prefer_typing_uninitialized_variables
import 'dart:convert';
import 'package:fluttertoast/fluttertoast.dart';
import 'package:http/http.dart' as http;
import 'package:carlink/controller/signup_controller.dart';
import 'package:carlink/screen/login_flow/login_screen.dart';
import 'package:carlink/screen/login_flow/otp_screen.dart';
import 'package:carlink/utils/App_content.dart';
import 'package:carlink/utils/Colors.dart';
import 'package:carlink/utils/Custom_widget.dart';
import 'package:carlink/utils/Dark_lightmode.dart';
import 'package:carlink/utils/config.dart';
import 'package:carlink/utils/fontfameli_model.dart';
import 'package:firebase_auth/firebase_auth.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:intl_phone_field/intl_phone_field.dart';
import 'package:onesignal_flutter/onesignal_flutter.dart';
import 'package:provider/provider.dart';
import 'package:shared_preferences/shared_preferences.dart';
import '../../controller/msg_otp_controller.dart';
import '../../controller/sms_type_controller.dart';
import '../../controller/twilio_otp_controller.dart';
import '../../model/signup_modal.dart';
import '../../utils/common.dart';
import '../bottombar/bottombar_screen.dart';

class SignUpScreen extends StatefulWidget {
  const SignUpScreen({super.key});

  @override
  State<SignUpScreen> createState() => _SignUpScreenState();
}

class _SignUpScreenState extends State<SignUpScreen> {
  SignUpController signUpController = Get.find();
  final GlobalKey<FormState> _formKey = GlobalKey<FormState>();

  var id;
  TextEditingController fullName = TextEditingController();
  TextEditingController emailController = TextEditingController();
  TextEditingController mobileController = TextEditingController();
  TextEditingController passwordController = TextEditingController();
  TextEditingController rCodeController = TextEditingController();
  String ccode = "";

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

  @override
  void initState() {
    // getdarkmodepreviousstate();
    fullName.text = "";
    emailController.text = "";
    mobileController.text = "";
    passwordController.text = "";
    rCodeController.text = "";
    super.initState();
  }

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

  SmsTypeController smsTypeController = Get.put(SmsTypeController());
  MsgOtpController msgOtpController = Get.put(MsgOtpController());
  TwilioOtpController twilioOtpController = Get.put(TwilioOtpController());

  getdatafromsingup() async {
    SharedPreferences prefs = await SharedPreferences.getInstance();
    var decode1 = prefs.getString('SingUpdata')!;
    print("++++++ $decode1");
    setState(() {
      decode = json.decode(decode1);
    });
  }

  var decode;

  @override
  Widget build(BuildContext context) {
    notifire = Provider.of<ColorNotifire>(context, listen: true);
    return Scaffold(
      resizeToAvoidBottomInset: true,
      backgroundColor: notifire.getbgcolor,
      body: SafeArea(
        child: SingleChildScrollView(
          child: Padding(
            padding: const EdgeInsets.symmetric(horizontal: 15),
            child: Form(
              key: _formKey,
              child: Stack(
                alignment: Alignment.center,
                children: [
                  Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      SizedBox(height: 10),
                      InkWell(
                        onTap: () {
                          Get.back();
                        },
                        child: Container(
                          height: 40,
                          width: 40,
                          alignment: Alignment.center,
                          padding: EdgeInsets.all(6),
                          child: Image.asset(Appcontent.close,
                              color: notifire.getwhiteblackcolor),
                        ),
                      ),
                      SizedBox(height: Get.size.height * 0.03),
                      Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          Text("Sign Up".tr,
                              style: TextStyle(
                                  fontFamily: FontFamily.europaBold,
                                  color: notifire.getwhiteblackcolor,
                                  fontSize: 28)),
                          SizedBox(height: Get.size.height * 0.04),
                          textFormFild(
                            notifire,
                            controller: fullName,
                            keyboardType: TextInputType.name,
                            prefixIcon: Padding(
                              padding: const EdgeInsets.all(12),
                              child: Image.asset(Appcontent.user,
                                  height: 25, width: 25, color: greyColor),
                            ),
                            labelText: "Full Name".tr,
                            validator: (value) {
                              if (value == null || value.isEmpty) {
                                return 'Please enter your name'.tr;
                              }
                              return null;
                            },
                          ),
                          SizedBox(height: 15),
                          textFormFild(
                            notifire,
                            controller: emailController,
                            keyboardType: TextInputType.emailAddress,
                            prefixIcon: Padding(
                              padding: const EdgeInsets.all(12),
                              child: Image.asset("assets/mail.png",
                                  height: 25, width: 25, color: greyColor),
                            ),
                            labelText: "Email".tr,
                            validator: (value) {
                              if (value == null || value.isEmpty) {
                                return 'Please enter your email'.tr;
                              }
                              return null;
                            },
                          ),
                          SizedBox(height: 15),
                          IntlPhoneField(
                            controller: mobileController,
                            decoration: InputDecoration(
                              counterText: "",
                              filled: true,
                              fillColor: notifire.getblackwhitecolor,
                              enabledBorder: OutlineInputBorder(
                                  borderSide: BorderSide.none,
                                  borderRadius: BorderRadius.circular(15)),
                              hintText: 'Phone Number'.tr,
                              hintStyle: TextStyle(
                                  color: greyColor,
                                  fontSize: 14,
                                  fontFamily: FontFamily.europaWoff),
                              border: OutlineInputBorder(
                                borderSide: BorderSide.none,
                                borderRadius: BorderRadius.circular(15),
                              ),
                              focusedErrorBorder: OutlineInputBorder(
                                borderSide: BorderSide(color: onbordingBlue),
                                borderRadius: BorderRadius.circular(15),
                              ),
                              focusedBorder: OutlineInputBorder(
                                borderSide: BorderSide(color: onbordingBlue),
                                borderRadius: BorderRadius.circular(15),
                              ),
                            ),
                            style: TextStyle(
                                color: notifire.getwhiteblackcolor,
                                fontFamily: FontFamily.europaBold),
                            flagsButtonPadding: EdgeInsets.only(left: 7),
                            showCountryFlag: false,
                            dropdownIcon:
                            Icon(Icons.phone_outlined, color: greyScale),
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
                          SizedBox(height: 15),
                          GetBuilder<SignUpController>(builder: (context) {
                            return textFormFild(
                              notifire,
                              controller: passwordController,
                              obscureText: signUpController.showPassword,
                              suffixIcon: InkWell(
                                onTap: () {
                                  signUpController.showOfPassword();
                                },
                                child: !signUpController.showPassword
                                    ? Padding(
                                  padding: const EdgeInsets.all(10),
                                  child: Image.asset(
                                    "assets/eye.png",
                                    height: 25,
                                    width: 25,
                                    color: greyColor,
                                  ),
                                )
                                    : Padding(
                                  padding: const EdgeInsets.all(10),
                                  child: Image.asset(
                                    "assets/eye-off.png",
                                    height: 25,
                                    width: 25,
                                    color: greyColor,
                                  ),
                                ),
                              ),
                              prefixIcon: Padding(
                                padding: const EdgeInsets.all(10),
                                child: Image.asset(
                                  "assets/lock.png",
                                  height: 25,
                                  width: 25,
                                  color: greyColor,
                                ),
                              ),
                              labelText: "Password".tr,
                              validator: (value) {
                                if (value == null || value.isEmpty) {
                                  return 'Please enter your password'.tr;
                                }
                                return null;
                              },
                            );
                          }),
                          SizedBox(height: 15),
                          textFormFild(
                            notifire,
                            controller: rCodeController,
                            prefixIcon: Padding(
                              padding: const EdgeInsets.all(12),
                              child: Image.asset(Appcontent.reffral,
                                  height: 25, width: 25, color: greyColor),
                            ),
                            labelText: "Referral code".tr,
                            validator: (value) {
                              if (value == null || value.isEmpty) {
                                return 'Please enter Referral Code'.tr;
                              }
                              return null;
                            },
                          ),
                          SizedBox(height: 10),
                          RichText(
                            text: TextSpan(
                              children: [
                                TextSpan(text: 'By signing up, you agree to our '.tr, style: TextStyle(fontFamily: FontFamily.europaWoff, color: notifire.getwhiteblackcolor, fontSize: 15)),
                                TextSpan(text: 'Terms of Service '.tr, style: TextStyle(fontFamily: FontFamily.europaBold, color: onbordingBlue, fontSize: 15)),
                                TextSpan(text: 'and '.tr, style: TextStyle(fontFamily: FontFamily.europaWoff, color: notifire.getwhiteblackcolor, fontSize: 15)),
                                TextSpan(text: 'Privacy Policy.'.tr, style: TextStyle(fontFamily: FontFamily.europaBold, color: onbordingBlue, fontSize: 15)),
                              ],
                            ),
                          ),

                          SizedBox(height: Get.size.height * 0.03),
                          GestButton(
                            height: 50,
                            Width: Get.size.width,
                            margin:
                            EdgeInsets.symmetric(horizontal: 15, vertical: 5),
                            buttoncolor: onbordingBlue,
                            buttontext: "Sign Up".tr,
                            style: TextStyle(
                                color: WhiteColor,
                                fontFamily: FontFamily.europaBold,
                                fontSize: 15),
                            onclick: () {
                                mCheck(mobileController.text, ccode).then((value) {
                                  if(value["ResponseCode"] == "200") {
                                    Fluttertoast.showToast(msg: value['ResponseMsg']);
                                    // registerID();
                                    smsTypeController.smsTypeApi().then((smsType) {
                                      if(smsType["Result"] == "true"){
                                        print("cscvdxvdcvfcbgbgn");
                                        if(smsType["otp_auth"] == "No"){
                                          // signUpController.setUserApiData(cuntryCode);
                                          signup(fullName.text, emailController.text, mobileController.text, passwordController.text, ccode).then((value) {
                                            if (value["ResponseCode"] == "200") {
                                              commonBottom();
                                              OneSignal.User.addTagWithKey("user_id", signUp?.userLogin.id);
                                              Fluttertoast.showToast(msg: value['ResponseMsg']);
                                            } else {
                                              Fluttertoast.showToast(msg: value['ResponseMsg']);
                                            }
                                          });
                                        }else {
                                          if (smsType["SMS_TYPE"] == "Firebase") {
                                            print("cscvdxvdcvfcbgbgn");
                                            registerID(smsType: smsType["SMS_TYPE"]);

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
                                                      Email: emailController.text,
                                                      FullName: fullName.text,
                                                      Password: passwordController.text,
                                                      Signup: "signUpScreen",
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
                                                      Email: emailController.text,
                                                      FullName: fullName.text,
                                                      Password: passwordController.text,
                                                      Signup: "signUpScreen",
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
                            },
                          ),
                          SizedBox(height: 13),
                          Row(
                            mainAxisAlignment: MainAxisAlignment.center,
                            children: [
                              SizedBox(width: 10),
                              Text("Already have and account?".tr, style: TextStyle(fontFamily: FontFamily.europaWoff, color: notifire.getwhiteblackcolor, fontSize: 15)),
                              SizedBox(width: 5),
                              InkWell(
                                onTap: () {
                                  Get.to(LoginScreen());
                                },
                                child: Text("Sign In".tr, style: TextStyle(fontFamily: FontFamily.europaBold, color: onbordingBlue, fontSize: 15)),
                              ),
                            ],
                          ),
                        ],
                      ),
                    ],
                  ),
                  isLoading ? loader() : SizedBox()
                ],
              ),
            ),
          ),
        ),
      ),
    );
  }

  Future registerID({required String smsType}) async {
    FirebaseAuth auth = FirebaseAuth.instance;
    SharedPreferences preferences = await SharedPreferences.getInstance();
    Map<String, dynamic> signUpData = {
      "name" : fullName.text,
      "email" : emailController.text,
      "mobile" : mobileController.text,
      "password" : passwordController.text,
      "ccode" : ccode,
      "rcode" : rCodeController.text
    };
    String encodeMap = json.encode(signUpData);
    preferences.setString('SingUpdata', encodeMap);
    try {
      setState(() {
        isLoading = true;
      });
      await auth.verifyPhoneNumber(
        phoneNumber: ccode + mobileController.text,
        timeout: Duration(seconds: 60),
        verificationCompleted: (phoneAuthCredential) async {
          await auth.signInWithCredential(phoneAuthCredential).then((value) {});
        },
        verificationFailed: (error) {},
        codeSent: (verificationId, forceResendingToken) {
          setState(() {
            isLoading = false;
          });
          Get.to(() =>
              OtpScreen(
                ccode: ccode,
                number: mobileController.text,
                Email: emailController.text,
                FullName: fullName.text,
                Password: passwordController.text,
                Signup: "signUpScreen",
                otpCode: "",
                msgType: smsType,

              ));
          // Navigator.push(context, MaterialPageRoute(builder: (context) => OtpScreen(mNumber: mobileController.text, country: ccode, vId: verificationId,)));
        },
        codeAutoRetrievalTimeout: (verificationId) {},
      );
    } catch (e) {}
  }

  SignUp? signUp;

  Future signup(fullname, email, mobile, password, ccode) async {
    Map body = {
      'name': fullname,
      'email': email,
      'mobile': mobile,
      'password': password,
      'ccode': ccode,
    };
    print(body);
    try {
      var response = await http.post(Uri.parse(Config.baseUrl + Config.signup), body: jsonEncode(body), headers: {
        'Content-Type': 'application/json',
      });
      SharedPreferences preferences = await SharedPreferences.getInstance();
      if (response.statusCode == 200) {
        var data = jsonDecode(response.body.toString());
        print(data);
        preferences.setString('Usertype', "USER");
        preferences.setString('UserLogin', jsonEncode(data["UserLogin"]));
        print("+ + + + + +  ++ + ++ + +  + + + + $data");
        setState(() {
          signUp = signUpFromJson(response.body);
        });
        return data;
      } else {}
    } catch (e) {}
  }

  Future commonBottom(){
    return Get.bottomSheet(
      backgroundColor: notifire.getbgcolor,
      shape: RoundedRectangleBorder(borderRadius: BorderRadius.vertical(top: Radius.circular(32))),
      SizedBox(
        height: 437,
        child: Column(
          mainAxisAlignment: MainAxisAlignment.spaceEvenly,
          crossAxisAlignment: CrossAxisAlignment.center,
          children: [
            SizedBox(height: 15,),
            Image.asset(Appcontent.accountsucess, height: 96, width: 96),
            Text('Account Successfully\nCreated!'.tr, style: TextStyle(fontSize: 24, fontFamily: 'gilroyBold', fontWeight: FontWeight.w700, color: notifire.getwhiteblackcolor), textAlign: TextAlign.center),
            Text('Awesome. Your account is\nready to use.'.tr, style: TextStyle(fontSize: 16, fontFamily: 'gilroy Medium', fontWeight: FontWeight.w500, color: greyScale), textAlign: TextAlign.center),
            GestButton(
              height: 50,
              Width: Get.size.width,
              margin: EdgeInsets.symmetric(vertical: 20, horizontal: 20),
              buttontext: 'Start exploring'.tr,
              style: TextStyle(fontFamily: FontFamily.europaBold, fontWeight: FontWeight.w700, fontSize: 16, color: Colors.white),
              onclick: () {
                Get.offAll(BottomBarScreen());
              },
              buttoncolor: onbordingBlue,
            ),
          ],
        ),
      ),
    );
  }

}
