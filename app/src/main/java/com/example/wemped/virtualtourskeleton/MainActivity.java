package com.example.wemped.virtualtourskeleton;

import android.support.v7.app.ActionBarActivity;
import android.os.Bundle;
import android.view.Gravity;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.LinearLayout;
import android.widget.RelativeLayout;
import android.widget.ScrollView;
import android.widget.Scroller;


public class MainActivity extends ActionBarActivity implements OnTaskCompleted {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        //setContentView(R.layout.activity_main);

        if (this.getIntent().getExtras() != null){
            //Check first run stuff?
            //Think this is only necessary for initial popup
        }else{
            //
        }
        generateHome();


    }


    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.menu_main, menu);
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


    private void generateHome(){

        //Basically the Screen, the very base layout for the main screen of the app
        RelativeLayout baseLayout = new RelativeLayout(this);
        RelativeLayout.LayoutParams matchParentMatchParent = new RelativeLayout.LayoutParams(RelativeLayout.LayoutParams.MATCH_PARENT,RelativeLayout.LayoutParams.MATCH_PARENT);
        baseLayout.setLayoutParams(matchParentMatchParent);
        baseLayout.setGravity(Gravity.CENTER);
        baseLayout.setId(R.integer.base_layout_id);

        //Allows everything within this view to scroll, So if we have too many buttons for a screen to show, we can scroll down
        //This will be attached to baseLayout
        ScrollView scrollView = new ScrollView(this);
        scrollView.setLayoutParams(matchParentMatchParent);
        scrollView.setId(R.integer.scroll_view_id);

        //Linear layout within the scrollView. This will contain other layouts/views like the map and the buttons
        LinearLayout scrollLayout = new LinearLayout(this);
        scrollLayout.setLayoutParams(matchParentMatchParent);
        scrollLayout.setOrientation(LinearLayout.VERTICAL);
        scrollLayout.setId(R.integer.scroll_layout_id);

        //Linear layout that will contain the map (and maybe the tabs/spinner?)
        LinearLayout mapLayout = new LinearLayout(this);
        mapLayout.setLayoutParams(matchParentMatchParent);
        mapLayout.setOrientation(LinearLayout.VERTICAL);
        mapLayout.setId(R.integer.map_layout_id);

        //This is the view within the mapLayout
        MapImageView mapView = new MapImageView(this);
        mapView.setLayoutParams(matchParentMatchParent);
        //mapView.setAdjustViewBounds(true);
        mapView.setId(R.integer.map_view_id);
        //mapView.setOnClickListener THIS SHOULD GET HANDLED IN MapImageView Class

        //This most likely will get changed from a Linear layout when working with
        //stop button adapter
        //This will hold all the buttons for the stops
        LinearLayout stopsLayout = new LinearLayout(this);
        stopsLayout.setLayoutParams(matchParentMatchParent);
        stopsLayout.setOrientation(LinearLayout.VERTICAL);
        stopsLayout.setId(R.integer.stop_button_layout_id);

        /*IGNORING QR CODE STUFF FOR NOW*/

        /*Giving all views their correct parent*/
        baseLayout.addView(scrollView);
        scrollView.addView(scrollLayout);
        scrollLayout.addView(mapLayout);
        mapLayout.addView(mapView);
        scrollLayout.addView(stopsLayout);

        /*Set the activity's view*/
        setContentView(baseLayout);

        /*Populate Views*/
        retrieveStops();
        retrieveMaps();
    }

    private void retrieveStops(){
        //Create a Async Task and start it.
        StopRetrievalTask sr = new StopRetrievalTask(this);
        sr.execute(-1);//-1 for get all stops
        //StopRetrievalTask will automatically set the global Stops
        //this.queuedContent++
    }

    private void retrieveMaps(){
        MapRetrievalTask mr = new MapRetrievalTask(this);
    }

    public void onTaskCompleted(Stop[] s){
        //This will run when retrieveStops() has completely finished its thread
    }
    public void onTaskCompleted(Map[] m){
        //This will run when retrieveMaps() has completely finished its thread
        //Create Tabs
        //Populate Stops
        //Add tabs to layout
    }
}
