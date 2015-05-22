package com.example.wemped.virtualtourskeleton;

import android.app.Activity;
import android.os.Bundle;
import android.support.v7.app.ActionBarActivity;
import android.util.Log;
import android.view.Gravity;
import android.view.Menu;
import android.view.MenuItem;
import android.view.MotionEvent;
import android.view.View;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.RelativeLayout;
import android.widget.ScrollView;
import android.widget.TableLayout;
import android.widget.TextView;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

/**
 * Created by wemped on 5/19/15.
 */
public class StopActivity  extends ActionBarActivity implements OnContentLoaded,View.OnClickListener, View.OnTouchListener, OnTaskCompleted {
    private static int STOP_ID = -1;
    private static int MAP_ID = -1;
    private static Stop stop = null;
    private static final RelativeLayout.LayoutParams matchParentMatchParent = new RelativeLayout.LayoutParams(RelativeLayout.LayoutParams.MATCH_PARENT,RelativeLayout.LayoutParams.MATCH_PARENT);
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
        setContentView(R.layout.activity_stop);
        this.stop = Globals.getStopById(getIntent().getExtras().getInt("STOP_ID"));

        if (Globals.getStops() == null){
            Log.v("retreving stops","all stops are null");
        }

        int stopid = getIntent().getExtras().getInt("STOP_ID");

        Log.v("retrieving stops","stopid = " + stopid);

        if (Globals.getStopById(stopid) == null){
            Log.v("retrieving stops","cant find that stop");
        }
        STOP_ID = this.stop.getStopID();
        MAP_ID = this.stop.getStopMapID();
        buildStop();
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
        setTitle(stop.getStopName());
        Log.v("stop_content = ", stop.getStopContent());
        Log.v("stop_room = ", stop.getStopRooNumber());
        Log.v("stop_order = ", Integer.toString(stop.getStopOrder()));

        StopRetrievalTask sr = new StopRetrievalTask(this);
        sr.execute(STOP_ID);

        /*JSONArray stopContent = null;
        try {
            stopContent = new JSONArray(stop.getStopContent());
        }catch(JSONException e){
            e.printStackTrace();
        }*/
        /*JSONArray stopContent = null;
        JSONObject object = null;
        try{
            object =(JSONObject) new JSONObject(stop.getStopContent());
            stopContent = (JSONArray)object.getJSONArray("result");
        }catch(JSONException e){
            e.printStackTrace();
        }*/

        /*for(int i = 0; i < stopContent.length(); i++)
        {
            try {
                JSONObject widget = stopContent.getJSONObject(i);
                String widgetType = widget.getString("type");

                if (widgetType.equals("text")) {

                    AddTextWidget(widget);
                }
                else if (widgetType.equals("image")){
                    AddImageWidget(widget);
                    //this.queuedContent ++;
                }
                else if (widgetType.equals("video")) {

                    AddVideoWidget(widget);
                    //this.queuedContent ++;
                }


            } catch (JSONException e) {
                // TODO Auto-generated catch block
                e.printStackTrace();
            }
        }*/
    }

    private void AddTextWidget(JSONObject Widget) throws JSONException{
        String titleString, content = "";

        titleString = Widget.getString("title");
        content = Widget.getString("content");


        //Title Text
        //TextView textTitle = GenerateTitle(titleString);
        TextView textTitle = new TextView(this);
        textTitle.setText(stop.getStopName());

        //Content Text
        TextView textContent = new TextView(this);
        textContent.setLayoutParams(matchParentMatchParent);
        textContent.setText("\t" + content);
        textContent.setGravity(Gravity.LEFT);

        LinearLayout MainLayout = (LinearLayout)findViewById(R.id.layout_stop);

        //Add content to screen
        MainLayout.addView(textTitle);
        MainLayout.addView(textContent);

    }

    private void AddImageWidget(JSONObject Widget) throws JSONException{

        //Retrieve values
        String urlString = Widget.getString("url");
        String titleString = Widget.getString("title");

        //Generate Content
        //TextView textTitle = GenerateTitle(titleString);
        TextView textTitle = new TextView(this);
        textTitle.setText(stop.getStopName());

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

    }

    private void AddVideoWidget(JSONObject Widget) throws JSONException {

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
        //TextView textTitle = GenerateTitle(titleString);
        TextView textTitle = new TextView(this);
        textTitle.setText(stop.getStopName());

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
    }
    @Override
    public void onClick(View v) {

    }
    @Override
    public void onContentLoaded() {

    }
    @Override
    public boolean onTouch(View v, MotionEvent event){
        return true;
    }

    @Override
    public void onTaskCompleted(Stop[] s) {
        Stop thisStop = s[0];
        this.stop = thisStop;

        JSONArray stopContent = null;
        try {
            stopContent = new JSONArray(stop.getStopContent());
        }catch(JSONException e){
            e.printStackTrace();
        }

        for(int i = 0; i < stopContent.length(); i++)
        {
            try {
                JSONObject widget = stopContent.getJSONObject(i);
                String widgetType = widget.getString("type");

                if (widgetType.equals("text")) {

                    AddTextWidget(widget);
                }
                else if (widgetType.equals("image")){
                    AddImageWidget(widget);
                    //this.queuedContent ++;
                }
                else if (widgetType.equals("video")) {

                    AddVideoWidget(widget);
                    //this.queuedContent ++;
                }


            } catch (JSONException e) {
                // TODO Auto-generated catch block
                e.printStackTrace();
            }
        }
    }

    @Override
    public void onTaskCompleted(Map[] m) {

    }
}
