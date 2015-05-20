package com.example.wemped.virtualtourskeleton;

import android.app.ActionBar;
import android.provider.Settings;
import android.support.v4.app.FragmentTransaction;
import android.content.Context;
import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentManager;
import android.support.v4.app.FragmentTabHost;
import android.support.v7.app.ActionBarActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.Gravity;
import android.view.LayoutInflater;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.FrameLayout;
import android.widget.LinearLayout;
import android.widget.RelativeLayout;
import android.widget.ScrollView;
import android.widget.Scroller;
import android.widget.TabHost;
import android.widget.TabWidget;
import android.widget.TextView;

import org.w3c.dom.Text;

import java.util.ArrayList;
import java.util.List;


public class MainActivity extends ActionBarActivity implements OnTaskCompleted {

    private boolean stopsMapsArrived = false;
    private FragmentManager fragmentManager = null;

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
        stopsMapsArrived = false;
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
        RelativeLayout.LayoutParams matchParentMatchParent = new RelativeLayout.LayoutParams(RelativeLayout.LayoutParams.MATCH_PARENT,RelativeLayout.LayoutParams.MATCH_PARENT);

        //Basically the Screen, the very base layout for the main screen of the app
        RelativeLayout baseLayout = new RelativeLayout(this);
        baseLayout.setLayoutParams(matchParentMatchParent);
        baseLayout.setGravity(Gravity.CENTER);
        baseLayout.setId(R.id.base_layout_id);

        //Linear layout within the baseLayout. Because we want a vertical-y structure to our app.
        LinearLayout mainLayout = new LinearLayout(this);
        mainLayout.setLayoutParams(matchParentMatchParent);
        mainLayout.setOrientation(LinearLayout.VERTICAL);
        mainLayout.setId(R.id.main_layout_id);

        //Linear layout that will contain the map and the tabs
        //In order to show tabs, the parent of the view that holds the tabs has to be a FRAMELAYOUT
        FrameLayout mapLayout = new FrameLayout(this);
        mapLayout.setLayoutParams(matchParentMatchParent);
        mapLayout.setId(R.id.map_layout_id);

        //This is the view within the mapLayout that will hold the map image
        MapImageView mapView = new MapImageView(this);
        mapView.setLayoutParams(matchParentMatchParent);
        //mapView.setAdjustViewBounds(true);
        mapView.setId(R.id.map_view_id);
        //mapView.setOnClickListener THIS SHOULD GET HANDLED IN MapImageView Class

        /*Layout for the TabHostFragment fragment to attach to. IMPORTANT: THIS MUST BE A CHILD TO A FRAMELAYOUT*/
        LinearLayout tabLayout = new LinearLayout(this);
        tabLayout.setLayoutParams(matchParentMatchParent);
        tabLayout.setOrientation(LinearLayout.VERTICAL);
        tabLayout.setId(R.id.tab_layout_id);

        /*IGNORING QR CODE STUFF FOR NOW*/

        /*Giving all views their correct parent*/
        baseLayout.addView(mainLayout);
        mainLayout.addView(mapLayout);
        mapLayout.addView(mapView);
        mapLayout.addView(tabLayout);

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
        mr.execute();
    }

    public void onTaskCompleted(Stop[] s){
        //This will run when retrieveStops() has completely finished its thread

        /*if we have both the maps and stops from the database, create our tabs and fill them in.*/
        if (stopsMapsArrived){
            createFloorTabs(this);
        }
        stopsMapsArrived = true;
    }
    public void onTaskCompleted(Map[] m){
        //This will run when retrieveMaps() has completely finished its thread

        /*if we have both the maps and stops from the database, create our tabs and fill them in.*/
        if (stopsMapsArrived){
            createFloorTabs(this);
        }
        stopsMapsArrived = true;
    }

    public void createFloorTabs(Context context){
        Log.v("in createFloorTabs","begin");
        fragmentManager = getSupportFragmentManager();
        FragmentTransaction fragmentTransaction = fragmentManager.beginTransaction();

        TabHostFragment tabHostFragment = new TabHostFragment(Globals.getMaps());
        fragmentTransaction.add(R.id.tab_layout_id,tabHostFragment,"TAB_HOST");

        fragmentTransaction.commitAllowingStateLoss();
    }
}
