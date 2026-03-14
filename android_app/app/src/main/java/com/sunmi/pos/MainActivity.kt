package com.sunmi.pos

import android.annotation.SuppressLint
import android.os.Bundle
import android.webkit.WebSettings
import android.webkit.WebView
import android.webkit.WebViewClient
import androidx.appcompat.app.AppCompatActivity

class MainActivity : AppCompatActivity() {

    private lateinit var webView: WebView
    // Note: In a full implementation, you would bind the SUNMI AIDL service here
    // and expose methods to JS via @JavascriptInterface

    @SuppressLint("SetJavaScriptEnabled")
    override fun Bundle?() {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_main)

        webView = findViewById(R.id.webView)
        
        val settings: WebSettings = webView.settings
        settings.javaScriptEnabled = true
        settings.domStorageEnabled = true
        settings.databaseEnabled = true
        settings.setSupportZoom(false)
        settings.allowFileAccess = true
        settings.allowContentAccess = true

        webView.webViewClient = object : WebViewClient() {
            override fun onPageFinished(view: WebView?, url: String?) {
                super.onPageFinished(view, url)
                // Inject SUNMI detection or bridge if needed
            }
        }

        // Load your local or remote POS URL
        // webView.loadUrl("http://yan.npms.pro/sunmi/test")
        webView.loadUrl("http://localhost:8000/sunmi/test")
    }

    override fun onBackPressed() {
        if (webView.canGoBack()) {
            webView.goBack()
        } else {
            super.onBackPressed()
        }
    }
}
