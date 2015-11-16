package com.example.wemped.virtualtourskeleton;

import java.util.*;
import java.lang.*;

import android.app.Activity;
import android.content.Intent;
import android.content.Intent.*;
import android.app.AlertDialog;
import android.content.DialogInterface;
import android.graphics.Color;
import android.graphics.PorterDuff;
import android.graphics.Typeface;
import android.os.Bundle;
import android.support.v4.app.FragmentActivity;
import android.support.v7.app.ActionBarActivity;
import android.text.SpannableString;
import android.text.style.UnderlineSpan;
import android.util.Log;
import android.view.Gravity;
import android.view.Menu;
import android.view.MenuItem;
import android.view.MotionEvent;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.view.GestureDetector.*;
import android.widget.FrameLayout;
import android.widget.FrameLayout.LayoutParams;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.RelativeLayout;
import android.widget.ScrollView;
import android.widget.TableLayout;
import android.widget.TextView;
import android.widget.Toast;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

/**
 * Created by wemped on 5/19/15.
 * Edit: class now extends FragmentActivity, which allows for the use of everything
 * currently implemented in this file to continue working, while allowing for simple
 * styling of the action bar to come from styles.xml -Nathaniel R.
 */
public class StopActivity  extends FragmentActivity implements OnContentLoaded,View.OnClickListener, View.OnTouchListener, OnTaskCompleted {
    private static int STOP_ID = -1;
    private static int MAP_ID = -1;
    private static int queuedContent=0;
    private static Stop stop = null;
    private static int NEXT_BTN_ID = 3726;
    private static int PREV_BTN_ID = 3762;
    private static final RelativeLayout.LayoutParams matchParentMatchParent = new RelativeLayout.LayoutParams(
            RelativeLayout.LayoutParams.MATCH_PARENT,
            RelativeLayout.LayoutParams.MATCH_PARENT);
    private static final LinearLayout.LayoutParams matchParentMatchParentLin = new LinearLayout.LayoutParams(
            LinearLayout.LayoutParams.MATCH_PARENT,
            LinearLayout.LayoutParams.MATCH_PARENT);
    public static final TableLayout.LayoutParams matchParentWrapContent = new TableLayout.LayoutParams(
            TableLayout.LayoutParams.MATCH_PARENT,
            TableLayout.LayoutParams.WRAP_CONTENT);
    public static final TableLayout.LayoutParams wrapContentMatchParent = new TableLayout.LayoutParams(
            TableLayout.LayoutParams.WRAP_CONTENT,
            TableLayout.LayoutParams.MATCH_PARENT,
            3f);
    public static RelativeLayout.LayoutParams wrapContentWrapContent = new RelativeLayout.LayoutParams(
            RelativeLayout.LayoutParams.WRAP_CONTENT,
            RelativeLayout.LayoutParams.WRAP_CONTENT
    );


    @Override
    protected void onCreate(Bundle savedInstanceState){
        super.onCreate(savedInstanceState);
        STOP_ID = getIntent().getExtras().getInt("STOP_ID");
    }

    public void onResume() {
        super.onResume();
        setContentView(R.layout.activity_stop);

        STOP_ID = getIntent().getExtras().getInt("STOP_ID");
        setTitle("");

        if (Globals.isOnline(this)){
            buildStop();

            //add back button to stops to bring users back to home page
            getActionBar().setDisplayHomeAsUpEnabled(true);
        } else {
            new AlertDialog.Builder(this)
                    .setTitle("No internet connection")
                    .setMessage("Please connect your device to the internet before using this application")
                    .setPositiveButton("Retry connection", new DialogInterface.OnClickListener() {
                        public void onClick(DialogInterface dialog, int which) {
                            dialog.dismiss();
                            onResume();
                        }
                    })
                    .setIcon(android.R.drawable.ic_dialog_alert)
                    .show();
        }
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.menu_stop, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle action bar item clicks here. The action bar will
        // automatically handle clicks on the Home/Up button, so long
        // as you specify a parent activity in AndroidManifest.xml.
        int id = item.getItemId();

        //noinspection SimplifiableIfStatement
        if (id == R.id.action_settings) {
            return true;
        }

        return super.onOptionsItemSelected(item);
    }


    private void buildStop(){

        ScrollView mainView = (ScrollView) findViewById(R.id.scroll_stop);


        LinearLayout mainLayout = (LinearLayout) findViewById(R.id.layout_stop);
        mainLayout.setOrientation(LinearLayout.VERTICAL);
        mainLayout.setVisibility(View.INVISIBLE);
        //mainView.setOnTouchListener(this);
        StopRetrievalTask sr = new StopRetrievalTask(this);
        //Log.v("building stop with id", Integer.toString(STOP_ID));+
        readyNavigationButtons();
        sr.execute(STOP_ID);
    }

    private void AddTextWidget(JSONObject Widget) throws JSONException{
        //Log.v("adding text widget","..");
        String titleString, content = "";

        titleString = Widget.getString("title");
        content = Widget.getString("content");

        //Title Text
        TextView textTitle = GenerateTitle(titleString);

        //Content Text
        TextView textContent = new TextView(this);
        textContent.setLayoutParams(matchParentMatchParent);
        textContent.setText(content);
        textContent.setGravity(Gravity.LEFT);
        textContent.setTypeface(Globals.getAvenir(this));

        LinearLayout MainLayout = (LinearLayout)findViewById(R.id.layout_stop);

        //Add content to screen
        MainLayout.addView(textTitle);
        MainLayout.addView(textContent);
        //Log.v("adding text widget","complete!");
    }

    private void AddImageWidget(JSONObject Widget) throws JSONException{
        //Log.v("adding image widget","..");
        //Retrieve values
        String urlString = Widget.getString("url");
        Log.v("url->",urlString);
        String titleString = Widget.getString("title");

        //Generate Content
        TextView textTitle = GenerateTitle(titleString);

        ImageView imageContent = new ImageView(this);
        imageContent.setLayoutParams(matchParentWrapContent);
        imageContent.setAdjustViewBounds(true);
        ImageRetrievalTask irt = new ImageRetrievalTask(imageContent,this);
        irt.execute(urlString);
        imageContent.setImageResource(R.drawable.placeholder);
        //Add content to screen
        LinearLayout MainLayout = (LinearLayout)findViewById(R.id.layout_stop);
        MainLayout.addView(textTitle);
        MainLayout.addView(imageContent);
        //Log.v("adding image widget","complete!");
    }

    private void AddVideoWidget(JSONObject Widget) throws JSONException {
        //Log.v("adding video widget","..");
        //Retrieve Values
        String urlString = Widget.getString("url");
        String titleString = Widget.getString("title");

        //Encapsulate image in a Relative Layout, this allows us to superimpose the play button on top
        RelativeLayout videoLayout = new RelativeLayout(this);
        videoLayout.setLayoutParams(matchParentMatchParent);

        ImageView videoPreview = new ImageView(this);
        videoPreview.setLayoutParams(wrapContentMatchParent);
        videoPreview.setImageResource(R.drawable.placeholder);
        videoPreview.setAdjustViewBounds(true);

        //Create a title for the view preview
        TextView textTitle = GenerateTitle(titleString);

        //Retrieve a thumbnail and set it to the image preview
        ThumbnailRetrievalTask trt = new ThumbnailRetrievalTask(videoPreview,this);
        videoPreview.setOnClickListener(this);
        trt.execute(urlString);
        videoPreview.setContentDescription(urlString);
        videoLayout.addView(videoPreview);

        //Add the play button to the center of the image
        ImageView playView = new ImageView(this);
        playView.setImageResource(R.drawable.play);
        playView.setLayoutParams(wrapContentWrapContent);
        RelativeLayout.LayoutParams lp = (android.widget.RelativeLayout.LayoutParams) playView.getLayoutParams();
        lp.addRule(RelativeLayout.CENTER_IN_PARENT);
        videoLayout.addView(playView);

        videoLayout.setOnTouchListener(this);

        //Add content to screen
        LinearLayout MainLayout = (LinearLayout)findViewById(R.id.layout_stop);
        MainLayout.addView(textTitle);
        MainLayout.addView(videoLayout);
        //Log.v("adding text widget","complete!");
    }
    @Override
    public void onClick(View v) {
        if (v.getId() == R.id.NEXT_BTN) {
            int next = getNextStop();

            if (next != -1)
            {
                Intent intent = new Intent(this,StopActivity.class);
                intent.putExtra("STOP_ID", next);
                intent.setFlags(intent.getFlags() | Intent.FLAG_ACTIVITY_NO_HISTORY);
                startActivity(intent);
            }
            else
            {
                Toast t = Toast.makeText(this, "Final stop in tour", Toast.LENGTH_LONG);
                t.show();
            }
        }if (v.getId() == R.id.PREV_BTN) {
            int next = getPrevStop();

            if (next != -1)
            {
                Intent intent = new Intent(this,StopActivity.class);
                intent.putExtra("STOP_ID", next);
                intent.setFlags(intent.getFlags() | Intent.FLAG_ACTIVITY_NO_HISTORY);
                startActivity(intent);
            }
            else
            {
                Toast t = Toast.makeText(this, "First stop in tour", Toast.LENGTH_LONG);
                t.show();
            }
        }else if (v instanceof ImageView){
            Intent intent = new Intent(getApplicationContext(), VideoPlayerActivity.class);
            intent.putExtra("url",v.getContentDescription());
            startActivity(intent);

        }
    }

    private void readyNavigationButtons()
    {
        Button next = (Button) findViewById(R.id.NEXT_BTN);
        Button prev = (Button) findViewById(R.id.PREV_BTN);

        next.setOnClickListener(this);
        prev.setOnClickListener(this);
    }



    @Override
    public void onContentLoaded() {
        this.queuedContent --;
        //Log.v("onContentLoaded -> queuedContent = ", Integer.toString(this.queuedContent));

        if (queuedContent == 0)
        {
            //loadingPopup.dismiss();
            LinearLayout MainLayout = (LinearLayout)findViewById(R.id.layout_stop);
            MainLayout.setVisibility(View.VISIBLE);
        }
    }
    @Override
    /*Need to fill in, thinking this is the swipe handler stuff!*/
    public boolean onTouch(View v, MotionEvent event){
        return true;
    }

    private int getNextStop() {

        Stop[] stops = Globals.getAllStops();

        for (int i = 0; i < stops.length - 1; i++)
        {
            if (stops[i].getStopID() == STOP_ID)
            {
                return stops[i+1].getStopID();
            }
        }
        return -1;
    }

    private int getPrevStop() {

        Stop[] stops = Globals.getAllStops();

        for (int i = 0; i < stops.length - 1; i++)
        {
            if (stops[i].getStopID() == STOP_ID)
            {
                if(i == 0){return -1;}
                return stops[i-1].getStopID();
            }
        }
        return -1;
    }

    private FrameLayout GenerateMarkedMap(float markx, float marky, int MapId)
    {
        ArrayList<Float> marks = new ArrayList<Float>();

        Stop[] stops = Globals.getStops();

        for (Stop s : stops)
        {
            if (s.getStopMapID() == MapId)
            {
                marks.add(s.getStopPositionX());
                marks.add(s.getStopPositionY());
            }
        }

        FrameLayout mapLayout = new FrameLayout(this);
        mapLayout.setLayoutParams(matchParentMatchParent);
        //Put map in layout
        MapImageView mapView = new MapImageView(this);
        mapView.setMapMarks(marks);
        mapView.setLayoutParams(matchParentWrapContent);
        mapView.setId(R.id.titleId);
        mapView.setImageResource(R.drawable.placeholder);
        mapView.setVisibility(View.INVISIBLE);
        mapView.setSelectedMark(markx, marky);
        mapView.setOnClickListener(this);

        Map map = null;

        for (Map m : Globals.getMaps())
        {
            if (m.getMapId() == MapId)
            {
                map = m;
                break;
            }
        }

        final Map thisMap = map;
        mapView.setContentDescription(thisMap.getMapUrl() + "," + thisMap.getMapId());

        mapView.post(new Runnable(){

            @Override
            public void run() {
                MapImageView map = (MapImageView) findViewById(R.id.titleId);
                ImageRetrievalTask irt = new ImageRetrievalTask(map,StopActivity.this);
                irt.execute(thisMap.getMapUrl());
                queuedContent++;

            }

        });
        mapView.setAdjustViewBounds(true);
        mapLayout.addView(mapView);

        return mapLayout;
    }


    @Override
    public void onTaskCompleted(Stop[] s) {
        Stop thisStop = s[0];
        this.stop = thisStop;
        this.MAP_ID = thisStop.getStopMapID();
        setTitle(this.stop.getStopName());
        JSONArray stopContent = null;
        try {
            stopContent = new JSONArray(thisStop.getStopContent());
        }catch(JSONException e){
            e.printStackTrace();
        }

        LinearLayout MainLayout = (LinearLayout)findViewById(R.id.layout_stop);
        MainLayout.addView(GenerateMarkedMap(thisStop.getStopPositionX(),thisStop.getStopPositionY(),thisStop.getStopMapID()));



        boolean hasTextWidget = false;

        for(int i = 0; i < stopContent.length(); i++)
        {
            try {
                JSONObject widget = stopContent.getJSONObject(i);
                String widgetType = widget.getString("type");




                if (widgetType.equals("text")) {
                    hasTextWidget = true;
                    AddTextWidget(widget);
                    //this.queuedContent ++;

                }
                else if (widgetType.equals("image")){
                    AddImageWidget(widget);
                    this.queuedContent ++;
                }
                else if (widgetType.equals("video")) {

                    AddVideoWidget(widget);
                    this.queuedContent ++;
                }



            } catch (JSONException e) {
                // TODO Auto-generated catch block
                e.printStackTrace();
            }
        }
        /*onContentLoaded needs to be called manually here because
        * AddTextWidget does not us a Task that calls onContentLoaded
        * without this, text only stops will appear to have no content*/
        if(hasTextWidget){
            this.queuedContent++;
            onContentLoaded();
        }
     }

    @Override
    /*Unneeded for this activity, but is necessary for stub to be here*/
    public void onTaskCompleted(Map[] m) {

    }
    private TextView GenerateTitle(String titleText) {

        //Make the Title Text Underlined
        SpannableString underlinedTitle = new SpannableString("\n" + titleText);
        underlinedTitle.setSpan(new UnderlineSpan(), 0, titleText.length(), 0);

        //Title Text
        TextView textTitle = new TextView(this);
        LinearLayout.LayoutParams titleparams = matchParentMatchParentLin;
        titleparams.gravity = Gravity.CENTER;
        textTitle.setLayoutParams(titleparams);
        textTitle.setTextSize(20);
        textTitle.setText(underlinedTitle);
        textTitle.setTypeface(Globals.getAvenir(this));

        return textTitle;

    }
}
